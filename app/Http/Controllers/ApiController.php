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
                        "link"  => "/blog/".$item->code,
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
        public function getCataloglist(Request $request) {
            $resultRestonse = [];
            $requestFormat = trim(strip_tags($request["query"]));

            $catalogItems = Catalog::select("id", "name", "code", "basic_section")
                                    ->where("code", "<>", "")
                                    ->where("name", "like", "%".$requestFormat."%")
                                    ->get();

            $arSections = CatalogsSection::select("id", "code", "parent_id")
                                            ->get()
                                            ->groupBy("id");

            if (!$catalogItems->isEmpty()) {
                foreach ($catalogItems as $item) {
                    if (!empty($arSections[$item->basic_section][0]->parent_id)) {
                        $mainSection =  $arSections[$arSections[$item->basic_section][0]->parent_id][0]->code;
                    } else {
                        $mainSection = "";
                    }
                    $image = Picture::select("path")
                                    ->where("element_id", "=", $item->id)
                                    ->first();

                    $arSuggestions[] = array(
                        "id"    => $item->id,
                        "value" => $item->name,
                        "code"  => $item->code,
                        "link"  => "/catalog/". $mainSection."/".$arSections[$item->basic_section][0]->code."/".$item->code."/",
                        "img" => $img = (!empty($image)) ? $image->path : "",
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

        // method for getting catalog elements
        public static function getCatalog($request) {
            if (!isset($request) || empty($request)) {
                return;
            }

            // check exist main_section
            if (isset($request["main_section"]) || !empty($request["main_section"])) {
                // general section
                if ($request["main_section"] == "elitnye") {
                    $mainSectionId = CatalogsSection::select("id")->where("code", "doma")->first()->id;
                } else {
                    $mainSectionId = CatalogsSection::select("id")->where("code", $request["main_section"])->first()->id;
                }

            }

            // check for the existence of the installed $ar_filter and isset $params from url
            if (isset($request["params"]) || !empty($request["params"])) {
                // create template query for getting elements from Model:Catalog
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

                $parseUrl = self::getParamsFormUrl($request["params"]);

                // get select sections
                $arSections = CatalogsSection::select("id")
                                                ->whereIn("code", $parseUrl["sections"])
                                                ->get()
                                                ->pluck("id")
                                                ->toArray();

                // get section
                if (empty($arSections)) {
                   $arSections = CatalogsSection::where("parent_id", $mainSectionId)
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
                if (empty($parseUrl["districts"])) {
                    $arDistricts = District::select("id", "code", "name")
                                            ->get()
                                            ->pluck("code")
                                            ->toArray();

                    $strDistrict = implode("', '", $arDistricts);
                } else {
                    $strDistrict = implode("', '", $parseUrl["districts"]);
                }

                $arReplace = [
                    "{section}"     => $strSections,
                    "{district}"    => $strDistrict,
                    "{countSection}"=> $arSectionsCount,
                ];

                $QUERY = strtr($QUERY, $arReplace);

                $elements = Catalog::select("id", "basic_section", "name", "code", "text_action", "price_ap_min", "cottage_village", "price", "price_m", "area");

                /*if (!empty($parseUrl["joins"])) {
                    $joins = $parseUrl["joins"];
                    $elements = $elements->leftJoin("element_directories", function ($join) use (&$joins) {
                                                        $join->on("catalog.id", "=", 'element_directories.element_id')
                                                             ->whereBetween("code", $joins);
                                                    });
                }*/

                $elements = $elements->whereRaw("id in ". $QUERY. "");


                if (!empty($parseUrl["between"])) {
                    foreach ($parseUrl["between"] as $keyBetween => $valBetween) {
                        $elements = $elements->whereBetween($keyBetween, $valBetween);
                    }
                }

                if (!empty($parseUrl["fields"])) {
                    $elements = $elements->where($parseUrl["fields"]);
                }

                if (isset($request["only_count"]) && $request["only_count"] == 1) {
                    $elements = $elements->get()
                                         ->count();
                } else {
                    $elements = $elements->orderBy("active", "1")
                                         ->orderBy("name", "asc")
                                         ->paginate(9)
                                         ->appends(request()->query());

                    $elements = Helper::getGsk($elements, $mainSectionId, $request["main_section"]);
                }

                return $elements;

            }

            if (isset($request["ar_filter"]) || !empty($request["ar_filter"])) {
                // select fields
                $arSelect = "";

                // orders for fields
                $arOrder = ["active" => "1"];

                // fields
                $arFields = $request["ar_filter"];

                if (isset($request["ar_select"]) || !empty($request["ar_select"])) {
                    $arSelect = $request["ar_select"];
                }

                if (isset($request["ar_order"]) || !empty($request["ar_order"])) {
                    $arOrder = $request["ar_order"];
                }

                $elements = Catalog::select($arSelect);

                if (isset($request["ar_filter_in"]) && $request["ar_filter_in"] == true ) {
                    foreach ($request["ar_filter"] as $keyArFilterIn => $valArFilterIn) {
                        $elements->whereIn($keyArFilterIn, $valArFilterIn);

                    }
                } else {
                    $elements->where($arFields);
                }

                foreach ($arOrder as $key => $value) {
                    $elements->orderBy($key, $value);
                }

                if (isset($request["only_count"]) && $request["only_count"] == 1) {
                    $elements = $elements->get()
                                         ->count();
                } else {
                    $elements = $elements->paginate(9)
                                         ->appends(request()->query());

                    $elements = Helper::getGsk($elements, "", "");
                }

                return $elements;

            }

            return false;

        }

        // method for getting parameters from url
        private static function getParamsFormUrl($url) {
            // result array
            $arResult = [];

            // fields
            $arFields = [];

            // select section filter
            $arSections = [];

            // range field
            $rangeFields = ["area_ap", "price_ap"];

            // range for where in
            $whereBetween = [];

            // all fields
            $inputs = explode("/", $url);

            // select districs
            $arDistricts = [];

            // joins
            $arJoin = [];

            // range joins
            $arJoinRange = ["number_rooms", "decorations"];

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
                        if ($fields[0] == "search") {
                            $arFields[] = ["name", "like", "%".$fields[1]."%"];
                            continue;
                        }
                        if ($fields[0] == "area" || $fields[0] == "price") {
                            $whereBetween[$fields[0]] = [(int)explode("_", $fields[1])[0], (int)explode("_", $fields[1])[1]];
                            continue;
                        }
                        if (in_array($fields[0], $arJoinRange) != false) {
                            $arJoin[] = (string)$fields[1];
                            continue;
                        }
                    }
                    $arFields[] = [$valInput, "1"];

                }

            }

            $arResult = [
                "sections"  => $arSections,
                "districts" => $arDistricts,
                "fields"    => $arFields,
                "between"   => $whereBetween,
                "joins"     => $arJoin,
            ];

            return $arResult;
        }

    //-- //API CATALOG--//
}
