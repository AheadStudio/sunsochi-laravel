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
use App\PopularQuery;

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
                        "img"   => $img = (!empty($image)) ? $image->path : "",
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
            if (!isset($request) && empty($request)) {
                return;
            }

            // check exist main_section
            if (isset($request["main_section"]) && !empty($request["main_section"])) {
                // general section
                if ($request["main_section"] == "elitnye") {
                    $section = ["kottedzhnye_poselki_elitnye", "elitnye_uchastki_v_sochi", "elitnye_doma_v_sochi", "elitnye_novostroyki_v_sochi", "elitnye_kvartiry_v_sochi"];
                    $mainSectionId = CatalogsSection::select("id")
                                                    ->whereIn("code", $section)
                                                    ->get()
                                                    ->pluck("id")
                                                    ->toArray();
                } elseif ($request["main_section"] == "lease" || $request["main_section"] == "resale" || $request["main_section"] == "building") {
                    $mainSectionId = CatalogsSection::select("id")
                                                    ->whereNotNull("parent_id")
                                                    ->get()
                                                    ->pluck("id")
                                                    ->toArray();
                } else {
                    $mainSectionId = CatalogsSection::select("id")
                                                    ->where("code", $request["main_section"])
                                                    ->first()
                                                    ->id;
                }

            }

            // check for the existence of the installed $ar_filter and isset $params from url
            if (isset($request["params"]) && !empty($request["params"])) {

                // parse url filter params
                $parseUrl = self::getParamsFormUrl($request["params"]);

                $elements = Catalog::select(
                    "catalogs.id",
                    "catalogs.active",
                    "catalogs.basic_section",
                    "catalogs.name",
                    "catalogs.code",
                    "catalogs.text_action",
                    "catalogs.price_ap_min",
                    "catalogs.cottage_village",
                    "catalogs.price_m",
                    "catalogs.price",
                    "catalogs.area",
                    "catalogs.gaz",
                    "catalogs.old_price",
                    "catalogs.floors",
                    "catalogs.floor"
                )
                ->join("catalogs_sections", function ($join) use (&$mainSectionId) {
                    $join->on("catalogs.basic_section", "=", "catalogs_sections.id");
                        if (is_array($mainSectionId)) {
                            $join->whereIn("catalogs_sections.id", $mainSectionId);
                        } else {
                            $join->where("catalogs_sections.parent_id", "=", $mainSectionId);
                        }
                });

                // use district
                if (!empty($parseUrl["listDistrict"])) {
                    $arListDistrict = $parseUrl["listDistrict"];
                    $elements = $elements->join("element_directories as el_code_district", function ($join) use (&$arListDistrict) {
                        $join->on("catalogs.id", "=", "el_code_district.element_id")
                             ->whereIn("el_code_district.code", $arListDistrict);
                    });
                }

                // use list fields
                if (!empty($parseUrl["listFields"])) {
                    foreach ($parseUrl["listFields"] as $keyList => $valList) {
                        $elements = $elements->join("element_directories as el_code_".$keyList, function ($join) use (&$keyList, &$valList) {

                            if ($keyList == 0) {
                                $join->on("catalogs.id", "=", "el_code_".$keyList.".element_id")
                                     ->where("el_code_".$keyList.".code", "=", $valList);
                            } else {
                                $newCode = $keyList-1;
                                $join->on("el_code_".$newCode.".element_id", "=", "el_code_".$keyList.".element_id")
                                     ->where("el_code_".$keyList.".code", "=", $valList);
                            }

                        });
                    }
                }

                if ($request["main_section"] == "lease" || $request["main_section"] == "resale" || $request["main_section"] == "building") {
                    $investments = $request["main_section"];
                    $elements = $elements->join("element_directories as el_code_investments", function ($join) use (&$investments) {
                        $join->on("catalogs.id", "=", "el_code_investments.element_id");
                            if ($investments == "resale") {
                                $join->where("el_code_investments.code", "=", "Tx2477Dx");
                            }
                            if ($investments == "lease") {
                                $join->where("el_code_investments.code", "=", "c5ILKt8a");
                            }
                            if ($investments == "building") {
                                $join->where("el_code_investments.code", "=", "Hdhotk6j");
                            }
                    });
                }

                if (!empty($parseUrl["between"])) {
                    foreach ($parseUrl["between"] as $keyBetween => $valBetween) {
                        $elements = $elements->whereBetween($keyBetween, $valBetween);
                    }
                }

                if (!empty($parseUrl["fields"])) {
                    $elements = $elements->where($parseUrl["fields"]);
                }

                $elements = $elements->where("catalogs.code", "<>", "");

                // check count or list elements
                if (isset($request["only_count"]) && $request["only_count"] == 1) {
                    $elements = $elements->get()
                                         ->count();

                    $countElements = $elements;
                } else {
                    $elements = $elements->orderBy("active", "1")
                                         ->orderBy("name", "asc")
                                         ->paginate(9)
                                         ->appends(request()->query());

                    $countElements = $elements->total();
                    if ($request["main_section"] == "lease" || $request["main_section"] == "resale" || $request["main_section"] == "building") {
                        $elements = Helper::getGsk($elements);
                    } else {
                        $elements = Helper::getGsk($elements, $mainSectionId, $request["main_section"]);
                    }

                }

                if (!empty($parseUrl["listFields"])) {
                    // +1 to popularity
                    foreach ($parseUrl["listFields"] as $value) {
                        //PopularQuery::where("url", "like", "%".$value)->update(["count_elements" => $countElements]);
                        PopularQuery::where("url", "like", "%".$value)->increment("popular", 1);
                    }
                }

                if (!empty($parseUrl["fields"])) {
                    foreach ($parseUrl["fields"] as $value) {
                        //PopularQuery::where("url", "like", "%".$value[0])->update(["count_elements" => $countElements]);
                        PopularQuery::where("url", "like", "%".$value[0])->increment("popular", 1);
                    }
                }

                return $elements;

            }

            // check exist ar_filter
            if (isset($request["ar_filter"]) && !empty($request["ar_filter"])) {
                // select fields
                $arSelect = "";

                // orders for fields
                $arOrder = ["active" => "1"];

                // fields
                $arFields = $request["ar_filter"];

                if (isset($request["ar_select"]) && !empty($request["ar_select"])) {
                    $arSelect = $request["ar_select"];
                }

                if (isset($request["ar_order"]) && !empty($request["ar_order"])) {
                    $arOrder = $request["ar_order"];
                }
                array_push($arSelect, "code");

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

                $elements->where("code", "<>", "");

                if (isset($request["only_count"]) && $request["only_count"] == 1) {
                    $elements = $elements->get()
                                         ->count();
                } else {
                    $elements = $elements->paginate(9)
                                         ->appends(request()->query());

                    $elements = Helper::getGsk($elements);
                }

                return $elements;

            }

            return false;

        }

        // method for getting parameters from url
        private static function getParamsFormUrl($url) {
            // result array
            $arResult = [];

            // fields elements
            $arFields = [];

            // list property elements from connected DB
            $arLists = [];

            // list property for whereIn
            $arListDistrict = [];

            // range field elements
            $rangeFields = ["area_ap", "price_ap"];

            // range one column elements
            $whereBetween = [];

            // all fields
            $inputs = explode("/", $url);

            foreach ($inputs as $keyInput => $valInput) {

                if (!empty($valInput)) {

                    if (strripos($valInput, "__")) {
                        $fields = explode("__", $valInput);

                        // for fields
                        if ($fields[0] == "section" ||
                            $fields[0] == "district" ||
                            $fields[0] == "number_rooms" ||
                            $fields[0] == "decoration" ||
                            $fields[0] == "relief" ||
                            $fields[0] == "predestination"
                        ) {
                            if ($fields[0] == "district") {
                                // +1 to popularity
                                District::where("code", $fields[1])
                                        ->increment("popular", 1);
                                $arListDistrict[] = $fields[1];
                                continue;
                            }
                            $arLists[] = $fields[1];
                            continue;
                        }

                        // for range apartments
                        if (in_array($fields[0], $rangeFields) != false) {
                            $arFields[] = [$fields[0] . "_min" , ">", explode("_", $fields[1])[0]];
                            $arFields[] = [$fields[0] . "_max" , "<", explode("_", $fields[1])[1]];
                            continue;
                        }

                        // search by name
                        if ($fields[0] == "search") {
                            $arFields[] = ["catalogs.name", "like", "%".$fields[1]."%"];
                            continue;
                        }

                        // between one columns
                        if ($fields[0] == "area" || $fields[0] == "price") {
                            $whereBetween[$fields[0]] = [(int)explode("_", $fields[1])[0], (int)explode("_", $fields[1])[1]];
                            continue;
                        }

                    }

                    $arFields[] = [$valInput, "1"];

                }

            }

            $arResult = [
                "listFields"    => $arLists,
                "listDistrict"  => $arListDistrict,
                "fields"        => $arFields,
                "between"       => $whereBetween,
            ];

            return $arResult;

        }

    //-- //API CATALOG--//
}
