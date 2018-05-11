<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CatalogController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\GoodCode\Helper;

use App\Catalog;
use App\CatalogsSection;
use App\CatalogsElement;
use App\Blog;
use App\ElementDirectory;
use App\District;
use App\Picture;
use App\NumberRoom;
use App\Builder;
use App\Deadline;

class ApiController extends Controller
{
    //-- API BLOG --//
        // method for get matches (autocomplate)
        public function getBlog(Request $request) {
            $resultRestonse = [];
            $requestFormat = trim(strip_tags($request["query"]));

            $blogItems = Blog::where([
                ["name", "like", "%".$requestFormat."%"],
            ])->get();

            if (!$blogItems->isEmpty()) {
                foreach ($blogItems as $item) {
                    $arSuggestions[] = array(
                        "id"    => $item->id,
                        "value" => $item->name,
                        "code"  => $item->code,
                    );
                    $resultRestonse = [
                        "suggestions" => $arSuggestions
                    ];
                }
            } else {
                $resultRestonse = [
                    "suggestions" => array(
                        array(
                            "id"    => "",
                            "value" => "Ничего не найдено"
                        )
                    )
                ];
            }
            return response()->json($resultRestonse);
        }

        // method for update rating
        public function updateRating(Request $request) {
            $blogItems = Blog::where("code", $request->code)
                             ->update([
                                 "rating"       => $request->rating,
                                 "summ_rating"  => $request->summ,
                                 "voted"        => $request->voted,
                             ]);
            return $request;
        }

    //-- //API BLOG --//


    //-- API CATALOG --//

        // autocomplate
        public function getDistrict(Request $request) {
            $resultRestonse = [];
            $requestFormat = trim(strip_tags($request["query"]));

            $districtItems = District::where([
                ["name", "like", "%".$requestFormat."%"],
            ])->get();

            if (!$districtItems->isEmpty()) {
                foreach ($districtItems as $item) {
                    $arSuggestions[] = array(
                        "id"    => $item->id,
                        "value" => $item->name,
                        "code"  => $item->code,
                    );
                    $resultRestonse = [
                        "suggestions" => $arSuggestions
                    ];
                }
            } else {
                $resultRestonse = [
                    "suggestions" => array(
                        array(
                            "id"    => "",
                            "value" => "Ничего не найдено"
                        )
                    )
                ];
            }
            return response()->json($resultRestonse);
        }

        // filter
        public function getCatalog(Request $request) {
            if (!isset($request) || empty($request)) {
                return;
            }
            // result request
            $resultFilter = [];

            // fields
            $arFields = [];

            // general section
            $mainSection = CatalogsSection::select("id")->where("code", $request["main_section"])->first()->id;

            // select section filter
            $arSections = [];

            // range field
            $rangeFields = ["area", "price"];

            // all fields
            $inputs = explode("/", $request["params"]);

            // select districs
            $arDistricts = [];

            foreach ($inputs as $keyInput => $valInput) {

                if (!empty($valInput)) {

                    if (strripos($valInput, "__")) {
                        $fields = explode("__", $valInput);

                        // for section
                        if ($fields[0] == "section") {
                            $arSections[] = $fields[1];
                            continue;
                        }
                        if (in_array($fields[0], $rangeFields) != false) {
                            $arFields[] = [$fields[0] . "_min" , ">", explode("_", $fields[1])[0]];
                            $arFields[] = [$fields[0] . "_max" , "<", explode("_", $fields[1])[1]];
                            continue;
                        }
                        if ($fields[0] == "district") {
                            $arDistricts[] = $fields[1];
                            continue;
                        }
                    }
                    $arFields[] = [$valInput, "on"];

                }
            }

            // get select sections
            $arSections = CatalogsSection::select("id")
                                            ->whereIn("code", $arSections)
                                            ->get()
                                            ->pluck("id")
                                            ->toArray();

            // create query
            $QUERY = "(SELECT element_id FROM (
                               SELECT element_id, count(element_id) as sections
                               FROM catalogs_elements
                               WHERE parent_id in ({section})
                               GROUP BY element_id
                           ) as s1
                           WHERE (s1.sections {countSection})
                           AND
                           s1.element_id in (
                               SELECT element_id FROM element_directories WHERE code in ('{district}')
                           )
                       )";

            // get section
            if (empty($arSections)) {
                $arSections = CatalogsSection::where("parent_id", $mainSection)
                                                ->get()
                                                ->pluck("id")
                                                ->toArray();
                $strSections = implode(", ", $arSections);
                $arSectionsCount = "LIKE '%'";
            } else {
                $strSections = implode(", ", $arSections);
                $arSectionsCount = " = ". count($arSections);
            }

            //get district
            if (empty($arDistricts)) {
                $arDistricts = District::select("id", "code", "name")
                                        ->get()
                                        ->pluck("code")
                                        ->toArray();

                $strDistrict = implode("', '", $arDistricts);
            } else {
                $strDistrict = implode("', '", $arDistricts);
            }

            $QUERY = str_replace("{section}", $strSections, $QUERY);
            $QUERY = str_replace("{countSection}", $arSectionsCount, $QUERY);
            $QUERY = str_replace("{district}", $strDistrict, $QUERY);

            if ($request["only_total"] == 1) {
                $elements = Catalog::select("id")
                                   ->whereRaw("id in ". $QUERY. "")
                                   ->where($arFields)
                                   ->get()
                                   ->count();
            } else {
                $elements = Catalog::select("id", "basic_section", "name", "code", "text_action", "price_min")
                                   ->whereRaw("id in ". $QUERY. "")
                                   ->where($arFields)
                                   ->orderBy("active", "1")
                                   ->orderBy("name", "asc")
                                   ->paginate(9)
                                   ->appends(request()->query());

                $elements = Helper::getGsk($elements, $mainSection, $request["main_section"]);
            }

            return response()->json($elements);
        }

    //-- //API CATALOG--//
}
