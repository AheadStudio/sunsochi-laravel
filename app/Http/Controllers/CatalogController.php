<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;

use App\GoodCode\ParseCatalog;
use App\GoodCode\Helper;

// table derictory
use App\Catalog;
use App\CatalogsSection;
use App\CatalogsElement;
use App\ElementDirectory;
use App\Chess;
use App\Street;
use App\StatusSales;
use App\Picture;
use App\Layout;
use App\PlanFloor;
use App\Builder;
use App\Deadline;
use App\District;
use App\NumberRoom;
use App\Predestination;
use App\PopularQuery;

use Session;
use Excel;
use File;


class CatalogController extends Controller
{
    // index page
    public function index() {
    	return view("catalog.index");
    }

    // section page
    public function section(Request $request, $section, $params = false) {
        // main array, which contain all params
        $pageParams = [];

        // array sections which belong to elements
        $arSections = [];

        // check catalog page and set settings for page
        $pageParams["pageSection"] = $section;
	    switch ($section) {
            case "novostrojki":
                $mainSectionId = 51;
                $pageParams["pageTitle"] = "Новостройки Сочи и Адлера";
                $pageParams["pageTabs"] = ["Вcе объекты проверены", "Квартиры<br>от 900 тысяч<br>рублей", "Гарантия цены<br>застройщика"];
                $pageParams["pageImage"] = "/dummy/new-bildings.jpg";
                break;
            case "kvartiry":
                $mainSectionId = 68;
                $pageParams["pageTitle"] = "Квартиры Сочи и Адлера";
                $pageParams["pageTabs"] = ["Вcе объекты проверены", "Квартиры<br>от 1,1 тысяч<br>рублей", "Гарантия цен<br>застройщика"];
                $pageParams["pageImage"] = "/dummy/apartments.jpg";
                break;
            case "elitnye":
                $pageParams["pageTitle"] = "Элитные дома Сочи и Адлера";
                $pageParams["pageTabs"] = ["Площади <br>200 — 1200 м<sup>2</sup>", "Квартиры<br>от 5,9 тысяч<br>рублей", "Гарантия <br>актуальной цены"];
                $pageParams["pageImage"] = "/dummy/houses.jpg";
                break;
            case "doma":
                $mainSectionId = 34;
                $pageParams["pageTitle"] = "Дома в Сочи и Адлера";
                $pageParams["pageTabs"] = ["Площади <br>50 — 1200 м<sup>2</sup>", "Дома <br>от 3,9 тысяч рублей", "Гарантия <br>актуальной цены"];
                $pageParams["pageImage"] = "/dummy/houses.jpg";
                break;
            case "uchastki":
                $mainSectionId = 18;
                $pageParams["pageTitle"] = "Участки в Сочи под любую <br>недвижимость";
                $pageParams["pageTabs"] = ["Площади <br>4 — 200 соток", "Участки <br>от 600 тысяч рублей", "Гарантия актуальной <br>цены"];
                $pageParams["pageImage"] = "/dummy/areas.jpg";
                break;
            case "kommercheskaya_nedvizhimost":
                $mainSectionId = 2;
                $pageParams["pageTitle"] = "Коммерческая недвижимость";
                $pageParams["pageTabs"] = ["Площади <br>4 — 200 соток", "Участки <br>от 600 тысяч рублей", "Гарантия актуальной <br>цены"];
                $pageParams["pageImage"] = "/dummy/areas.jpg";
                break;
        }

        // get district
        $pageParams["district"] = District::select("id", "code", "name", "popular")
                                          ->get();

        $pageParams["popularDistrict"] = $pageParams["district"]->take(6)
                                                                ->sortByDesc("popular");

        // get predestination
        $pageParams["predestination"] = Cache::remember("catalogPredestination", 60, function() {
            return Predestination::select("id", "code", "name")->get();
        });

        // get popular query
        $pageParams["popularQuery"] = PopularQuery::get()
                                                  ->sortByDesc("popular");

        // check filter
        if (!empty($params) && $params != false) {
            // construct request
            $request = [
                "url"           => $request->url(),
                "params"        => $params,
                "main_section"  => $section,
            ];

            $elements = ApiController::getCatalog($request);

            $pageParams["offers"]       = $elements;
            $pageParams["countOffers"]  = $elements->total();
            $pageParams["showFind"]     = true;

        } else {
            if ($section == "elitnye") {
                $mainSectionId  = [15, 31, 35, 66, 83];

                $elements = Catalog::whereIn("basic_section", $mainSectionId)
                                   ->paginate(9);
            } else {
                $elements = CatalogsSection::where("parent_id", $mainSectionId)
                                            ->first()
                                            ->getCatalogElements()
                                            ->where("code", "<>", "")
                                            ->distinct()
                                            ->paginate(9);
            }

            $elements = Helper::getGsk($elements, $mainSectionId, $section);

            $pageParams["offers"]       = $elements;
            $pageParams["countOffers"]  = $elements->total();
            $pageParams["showFind"]     = true;

        }

        // set SEO for page
        Helper::setSEO(
            $pageParams["pageTitle"],
            "Каталог компании “Солнечный Сочи”",
            URL::current()
        );

	    return view("catalog/section", $pageParams);

    }

    // method for get catalog items
    public function getFilterItems(Request $request) {
        //set parameters for request
        $request = [
            "url"           => $request->url(),
            "params"        => $request->params,
            "main_section"  => $request->main_section,
            "only_count"    => $request->only_count,
        ];

        $elements = ApiController::getCatalog($request);

        $pageParams["offers"]       = $elements;
        $pageParams["countOffers"]  = $elements->total();
        $pageParams["showFind"]     = true;

        return view("catalog/section-items", $pageParams);

    }

    // method for get catalog items count
    public function getFilterCount(Request $request) {
        //set parameters for request
        $request = [
            "url"           => $request->url(),
            "params"        => $request->params,
            "main_section"  => $request->main_section,
            "only_count"    => $request->only_count,
        ];

        $elements = ApiController::getCatalog($request);

        return view("catalog/sections-filter-button", ["countElements" => $elements]);

    }

    // method for add elements in favorite
    public function addFavorite(Request $request) {
        $newCookie = Helper::handlerCookie($request["element_id"], "post");
        return response()->json(["count" => count($newCookie)])->withCookie(cookie("sunsochi-favorite", json_encode($newCookie), 60*24*30));
    }

    // method for get elements from favorite
    public function getFavorite(Request $request) {
        $arFields = [];
        $pageParams = [];

        // get all elements
        $newCookie = Helper::handlerCookie($request["element_id"], "post");

        if (!empty($newCookie)) {
            foreach ($newCookie as $valId) {
                $arFields[] = $valId;
            }
            $request = [
                "url"           => $request->url(),
                "ar_filter"     => ["id" => $arFields],
                "ar_filter_in"  => true,
                "ar_select"     => ["id", "basic_section", "name", "code", "text_action", "price_ap_min", "price", "cottage_village", "price_m", "area"]
            ];

            $elements = ApiController::getCatalog($request);

            $pageParams["offers"]       = $elements;
            $pageParams["countOffers"]  = $elements->total();
            $pageParams["showFind"]     = false;

        } else {

            $elements = new \stdClass;
            $pageParams["offers"] = $elements;

        }

        $pageParams["notShowAdd"]   = 1;
        $pageParams["showFind"]     = false;

        // set SEO for page
        Helper::setSEO(
            "Избранное",
            "Каталог компании “Солнечный Сочи”",
            URL::current()
        );

        return view("favorite", $pageParams);

    }

    // detail page
    public function show(Request $request, $section, $subsection, $code) {
        //try {
            $element = Catalog::where("code", $code)
                              ->get()
                              ->toArray()[0];

            if (empty($element)) {
                return redirect(404);
            }

            if ($section == "elitnye") {
                $idSubsection = $element["basic_section"];
                $mainSectionId = CatalogsSection::select("id", "code")
                                                ->where("catalogs_sections.id", function ($query) use(&$idSubsection) {
                                                    $query->select("catalogs_sections.parent_id")
                                                          ->from(with(new CatalogsSection)->getTable())
                                                          ->where("catalogs_sections.id", $idSubsection);
                                                })
                                                ->first();
                if (is_null($mainSectionId)) {
                    dd("Указы не верные параметры: секция = ".$section.",подсекция = ". $subsection."код элемента = ".$code);
                } else {
                    $mainSectionId = $mainSectionId->id;
                }
            } else {
                $mainSectionId = CatalogsSection::where("code", $section)->first()->id;
            }

            $element["picture"] = Picture::where("element_id", $element["id"])
                                         ->get()
                                         ->toArray();

            $element["code_fields"] = ElementDirectory::where("element_id", $element["id"])
                                                      ->get()
                                                      ->groupBy("name_table")
                                                      ->toArray();

            $chess = Chess::select("id", "section_list", "section_name", "section_lenght")
                          ->where("element_id", $element["id"])
                          ->first()
                          ->toArray();

            if (!empty($chess)) {
                $element["chess"] = $chess;
                $element["chess"]["section_names"] = explode(",", $chess["section_name"]);
            }

            // add property in array element
            foreach ($element["code_fields"] as $keyElementCode => $valElementCode) {
                foreach ($valElementCode as $keyCode => $valCode) {
                    $className = "\App\\".$keyElementCode;
                    $element["code_fields"][$keyElementCode][$keyCode]["property"] = $className::where("code", $valCode["code"])->get()->toArray()["0"];
                }
            }

            // get similar object
            $similarElements = CatalogsSection::where("code", $subsection)
                                              ->first()
                                              ->getCatalogElements();

            // set similar region / district
            /*$districtCode = $element["code_fields"]["District"][0]["code"];
            if (!empty($districtCode)) {
                $similarElements->join("element_directories", function ($join) use (&$districtCode) {
                        $join->on("element_directories.element_id", "=", "catalogs.id")
                             ->where("element_directories.code", $districtCode);
                });
            }*/

            $similarElements = $similarElements->whereBetween("price", [$element["price"] / 1.5, $element["price"] * 1.5])
                                               ->where("code", "<>", "")
                                               ->take(3)
                                               ->get();

            $similarElements = Helper::getGsk($similarElements, $mainSectionId, $section);

            $newCookie = Helper::handlerCookie($element["id"], "get");
            if ($newCookie == true) {
                $element["check_cookie"] = 1;
            }

            if ($section == "novostrojki") {
                // sekect apartments in new building
                $arApartments = Catalog::where("cottage_village", $element["id"]);

                // all apartments
                $allApartments = clone $arApartments;

                // all free apartments
                $onlyFreeTable = clone $arApartments;

                $element["all_apartments"] = $allApartments->select("id", "name", "catalogs.code as ap_code", "area", "price", "price_m", "old_price", "text_action", "status_sale")
                                                           ->where("status_sale", "!=", "1")
                                                           ->get()
                                                           ->groupBy("id")
                                                           ->toArray();

                foreach ($element["all_apartments"] as $keyAp => $valAp) {
                    if ($valAp[0]["status_sale"] == 2) {
                        $element["all_apartments"][$keyAp][0]["color"] = "#848783";
                    }
                    if ($valAp[0]["status_sale"] == 3) {
                        $element["all_apartments"][$keyAp][0]["color"] = "#ffe200";
                    }
                    if ($valAp[0]["status_sale"] == 4) {
                        $element["all_apartments"][$keyAp][0]["color"] = "#ffa62f";
                    }
                }

                // get free apartments for table
                $element["free_apartments"] = $onlyFreeTable->select("catalogs.id",
                                                                     "catalogs.name",
                                                                     "catalogs.code as ap_code",
                                                                     "catalogs.floor",
                                                                     "catalogs.area",
                                                                     "catalogs.price",
                                                                     "catalogs.price_m",
                                                                     "catalogs.old_price",
                                                                     "number_rooms.name as number_rooms_name",
                                                                     "number_rooms.code as number_rooms_code",
                                                                     "decorations.name as decorations_name",
                                                                     "decorations.code as decorations_code",
                                                                     "subsection.code as subsection_code",
                                                                     "section.code as section_code"
                                                                     )
                                                                     ->where("catalogs.status_sale", "=", 1)
                                                                     ->join("catalogs_sections as subsection", "subsection.id", "=", "catalogs.basic_section")
                                                                     ->join("catalogs_sections as section", "section.id", "=", "subsection.parent_id")
                                                                     ->join("element_directories as element_decoration", function ($join) {
                                                                         $join->on("element_decoration.element_id", "=", "catalogs.id")
                                                                                 ->where("element_decoration.name_field", "decoration");
                                                                     })
                                                                     ->join("element_directories as element_number_rooms", function ($join) {
                                                                         $join->on("element_number_rooms.element_id", "=", "catalogs.id")
                                                                                 ->where("element_number_rooms.name_field", "number_rooms");
                                                                     })
                                                                     ->join("decorations", "decorations.code", "=", "element_decoration.code")
                                                                     ->join("number_rooms", "number_rooms.code", "=", "element_number_rooms.code")
                                                                     ->get()
                                                                     ->groupBy("id")
                                                                     ->toArray();
                // counter for different apartments
                $element["decoration_count"]["8hJkbSPc"] = 0;
                $element["decoration_count"]["T6ZqlhAt"] = 0;
                $element["decoration_count"]["1lKIq2Yc"] = 0;

                //get layout
                if (!empty($element["free_apartments"])) {
                    $layoutApartments = Layout::select("id", "path", "element_id")
                                              ->whereIn("element_id", array_keys($element["free_apartments"]))
                                              ->get()
                                              ->groupBy("element_id")
                                              ->toArray();

                    // add propery in apartmens such as: color, layouts
                    foreach ($element["free_apartments"] as $keyAp => $valAp) {

                        if (isset($valAp[0]["decorations_code"])) {
                            // без отделки
                            if ($valAp[0]["decorations_code"] == "8hJkbSPc") {
                                $element["free_apartments"][$keyAp][0]["color"] = "#498FE1";
                                $element["decoration_count"]["8hJkbSPc"]++;
                            }
                            // с ремонтом
                            if ($valAp[0]["decorations_code"] == "T6ZqlhAt") {
                                $element["free_apartments"][$keyAp][0]["color"] = "#0036cb";
                                $element["decoration_count"]["T6ZqlhAt"]++;
                            }
                            // предчистовая
                            if ($valAp[0]["decorations_code"] == "1lKIq2Yc") {
                                $element["free_apartments"][$keyAp][0]["color"] = "#b43894";
                                $element["decoration_count"]["1lKIq2Yc"]++;
                            }
                        }

                        if (array_key_exists($keyAp, $layoutApartments)) {
                            $element["free_apartments"][$keyAp][0]["image_path"] = $layoutApartments[$keyAp][0]["path"];
                        } else {
                            $element["free_apartments"][$keyAp][0]["image_path"] = '';
                        }

                        //check cooie and add to element
                        $element["free_apartments"][$keyAp][0]["check_cookie"] = 0;
                        $newCookie = Helper::handlerCookie($element["free_apartments"][$keyAp][0]["id"], "get");
                        if ($newCookie == true) {
                            $element["free_apartments"][$keyAp][0]["check_cookie"] = 1;
                        }

                        // add route
                        $element["free_apartments"][$keyAp][0]["link"] = route("CatalogShow", [$valAp[0]["section_code"], $valAp[0]["subsection_code"], $valAp[0]["ap_code"]]);
                    }

                    // add in main array
                    foreach ($element["free_apartments"] as $keyAp => $valAp) {
                        $element["all_apartments"][$keyAp] = $valAp;
                    }

                }
                $picture = Layout::select("path", "element_id")
                                 ->whereIn("element_id", array_keys($element["all_apartments"]))
                                 ->get()
                                 ->groupBy("element_id")
                                 ->toArray();

                foreach ($element["all_apartments"] as $keyAp => $valAp) {
                    $chessApartment = Chess::where("element_id", $keyAp)
                                           ->first();
                    if (!is_null($chessApartment)) {
                        $chessApartment = $chessApartment->toArray();
                        if (!empty($chessApartment)) {
                            $chessApartment = Helper::chessFormat($chessApartment["old_obj"], $chessApartment["old_width"], $chessApartment["old_height"]);
                            $element["chess_apartments"]["section"][$chessApartment["section"]][$keyAp] = $valAp[0];
                            $element["chess_apartments"]["section"][$chessApartment["section"]][$keyAp]["chess"] = $chessApartment["chess_obj"];
                            //$element["all_apartments"][$keyAp][0]["chess"]["section"][$chessApartment["section"]][] = $chessApartment["chess_obj"];
                        }
                    } else {
                        $element["all_apartments"][$keyAp][0]["chess"] = "";
                    }
                }
                
                if (!empty($element["developer_buildings"])) {
                    $element["builder"] = Builder::where("id", $element["developer_buildings"])->first()->toArray();
                    $element["builder"]["url"] = route("BuildersShow", [$element["builder"]["code"]]);
                }

                if (!empty($element["infrastructure"])) {
                    $element["infrastructure"] = preg_replace("/&#?[a-z0-9]+;/i","",$element["infrastructure"]);
                    $element["infrastructure"] = str_replace("br", "", explode("\r\n", $element["infrastructure"]));
                }

                if (!empty($element["include"])) {
                    $element["include"] = preg_replace("/&#?[a-z0-9]+;/i","",$element["include"]);
                    $element["include"] = str_replace("br", "", explode("\r\n", $element["include"]));
                }

                $pageParams = [
                    "section" => $section,
                    "element" => $element,
                    "similarElements" => $similarElements,
                ];

                // set SEO for page
                Helper::setSEO(
                    $element["name"],
                    $element["detail_text"],
                    URL::current()
                );
                //dd($element);
                return view("catalog/detail-newbuildings", $pageParams);

            } else {

                // if gk for this element
                $cottage = [];
                if (!empty($element["cottage_village"])) {
                    $cottage = Catalog::select("catalogs.id", "catalogs.name", "catalogs.code", "catalogs.basic_section", "catalogs_sections.code as subsection")
                                        ->where("catalogs.id", $element["cottage_village"])
                                        ->join("catalogs_sections", "catalogs_sections.id", "=", "catalogs.basic_section")
                                        ->first()
                                        ->toArray();
                    // create url for gk
                    $cottage["url"] = "/catalog/novostrojki/".$cottage["subsection"]."/".$cottage["code"];
                }

                $pageParams = [
                    "section" => $section,
                    "element" => $element,
                    "cottage" => $cottage,
                    "similarElements" => $similarElements,
                ];

                // set SEO for page
                Helper::setSEO(
                    $element["name"],
                    $element["detail_text"],
                    URL::current()
                );

                return view("catalog/detail", $pageParams);
            }
        // } catch (\Exception $e) {
        //     return redirect(404);
        // }


    }

    /**
     * View import page
     *
     * @return \Illuminate\Http\Response
     */
    public function import() {
        return view("import", ["action" => route("CatalogImportSend")]);
    }

    /**
     * Import in catalog
     *
     * @param  \Illuminate\Http\Request  $request
     * @return object after added catalog
     */
    public function importHandler(Request $request) {
        $this->validate($request, array(
            "file"  =>  "required"
        ));

        $file = $request->file;

        // folder download
        $destinationPath = "upload";

        // push file in folder
        $filePath = $file->move($destinationPath, $file->getClientOriginalName());

        // open file for reading
        $fileOpen = fopen($_SERVER["DOCUMENT_ROOT"]."/".$filePath, "r");
        $expanFile = \File::extension($_SERVER["DOCUMENT_ROOT"]."/".$filePath);

        // read this file and write his data in array
        while (($readFile = fgetcsv($fileOpen, 100000000, ";")) !== FALSE) {
            foreach ($readFile as $keyreadFile => $valreadFile) {
                $readFile[$keyreadFile] = $valreadFile;
            }
            $arrReadFile[] = $readFile;
        }

        $classParseCatalog = new ParseCatalog($arrReadFile);
        $parseCatalog = $classParseCatalog->parseCatalog();

        echo "<pre>"; print_r("Распарсено ".count($parseCatalog)." элементов"); echo "</pre>";

        foreach ($parseCatalog as $keyParseCatalog => $valParseCatalog) {
            $mainSectionElement = "";
            $sectionElement = [];
            $idPhotos = [];
            $idLayout = [];
            $idPlanFloor = [];


            // add main section
            $addIblock = CatalogsSection::firstOrCreate(
                ["active"      => 1,
                 "parent_id"   => null,
                 "name"        => $valParseCatalog["IBLOCK_NAME"],
                 "code"        => $valParseCatalog["IBLOCK_CODE"],
                 "picture"     => null]
            );

            // add subsection
            if (!empty($valParseCatalog["SECTIONS_ID"])) {
                foreach ($valParseCatalog["SECTIONS_ID"] as $keySection => $valSection) {

                    $addSection = CatalogsSection::firstOrCreate(
                        ["active"     => 1,
                         "parent_id"  => $addIblock->id,
                         "name"       => $valParseCatalog["SECTIONS_NAME"][$keySection],
                         "code"       => $valParseCatalog["SECTIONS_CODE"][$keySection],
                         "picture"    => null]
                    );

                    $sectionElement[] = $addSection->id;

                    if ($valParseCatalog["IBLOCK_SECTION_ID"] == $valSection) {
                        $mainSectionElement = $addSection->id;
                    }

                }

            }


            if (!empty($valParseCatalog["STREET_ELEM_NAME"])) {
                $addStreet = Street::firstOrCreate(
        		    ["name"   =>  $valParseCatalog["STREET_ELEM_NAME"]]
        		);
            }
            if (!empty($valParseCatalog["STATUS_LIST_VALUE"])) {
                $addStatus = StatusSales::firstOrCreate(
        		    ["name"           =>  $valParseCatalog["STATUS_LIST_VALUE"],
                     "code"           =>  $valParseCatalog["STATUS_LIST_XML_ID"],
                     "description"    => null]
        		);
            }

            // add photos
            if (!empty($valParseCatalog["PHOTO_ISFILE"])) {

                foreach ($valParseCatalog["PHOTO_ISFILE"] as $keyProp => $valProp) {
                    $nameFile = $valParseCatalog["CODE"].mb_substr($valProp, -6, 6);

                    $addProp = Picture::firstOrCreate(
            		    ["element_id"     => null,
            		     "name"           => $nameFile,
            		     "path"           => $valProp,
            		     "description"    => null]
            		);

                    $idPhotos[] = $addProp->id;
                }

            }

            // add layout (планировка)
            if (!empty($valParseCatalog["PLANIR_ISFILE"])) {

                foreach ($valParseCatalog["PLANIR_ISFILE"] as $keyProp => $valProp) {
                    $nameFile = $valParseCatalog["CODE"].mb_substr($valProp, -6, 6);

                    $addProp = Layout::firstOrCreate(
            		    ["element_id"     => null,
            		     "name"           => $nameFile,
            		     "path"           => $valProp,
            		     "description"    => null]
            		);

                    $idLayout[] = $addProp->id;
                }

            }

            // add plan houses (планировка)
            if (!empty($valParseCatalog["PLAN_ETAGEY_ISFILE"])) {

                foreach ($valParseCatalog["PLAN_ETAGEY_ISFILE"] as $keyProp => $valProp) {
                    $nameFile = $valParseCatalog["CODE"].mb_substr($valProp, -6, 6);

                    $addProp = PlanFloor::firstOrCreate(
            		    ["element_id"     => null,
            		     "name"           => $nameFile,
            		     "path"           => $valProp,
            		     "description"    => null]
            		);

                    $idPlanFloor[] = $addProp->id;
                }

            }


            // || add property from highload block || //

            // code property
            $codeProp = [];

            // array of comparisons of old property names with new names
            $arrOldNameProps = array(
                "TYPE"                  => "TypeBuilding|type_building",
                "OTDELKA"               => "Decoration|decoration",
                "PARKOVKA"              => "ParkingPlaces|parking_places",
                "COMMUN"                => "Communication|communication",
                "KOMMUNIKACII"          => "Communication|communication",
                "OTOPLENIE"             => "Heating|heating",
                "KANAL"                 => "Sewerage|sewerage",
                "KANALIZACIYA"          => "Sewerage|sewerage",
                "RAION"                 => "District|district",
                "RAJON"                 => "District|district",
                "STEPENV"               => "Importance|importance",
                "MNG_STEPENV"           => "Importance|importance",
                "INVEST"                => "ForInvestment|for_investment",
                "DOPS"                  => "AddOptions|add_options",
                "FUNCTION"              => "Predestination|predestination",
                "SROK_SDACHI"           => "Deadline|deadline",
                "CLASS"                 => "ClassBuildings|class_building",
                "ETAG"                  => "NumberFloor|number_floor",
                "MASHINOMEST"           => "PlacesCar|places_car",
                "VODA"                  => "Water|water",
                "CELL"                  => "PurposePurchases|purpose_purchases",
                "CEL_POKUPKI"           => "PurposePurchases|purpose_purchases",
                "TYPE_HOUSE"            => "TypeHouse|type_house",
                "SANUZ"                 => "Bathroom|bathroom",
                "SAN_UZEL"              => "Bathroom|bathroom",
                "ETAZH_OT"              => "NumberFloor|floor_from",
                "ETAZH_DO"              => "NumberFloor|floor_to",
                "KATEG"                 => "AssignmentCategory|assignment_categories",
                "RELIF"                 => "Relief|relief",
                "CLASS_NEWSTROY"        => "ClassBuildings|class_building",
                "KOLICHESTVO_KOMNAT"    => "NumberRoom|number_rooms",
            );

            // иду по свойствам
            foreach ($valParseCatalog as $keyPropEl => $valPropEl) {

                // проверяю наличие их в массиве по ключу
                if (array_key_exists(mb_strtoupper($keyPropEl), $arrOldNameProps)) {

                    if (is_array($valParseCatalog[$keyPropEl])) {
                        foreach ($valParseCatalog[$keyPropEl]["ALL_VALUE"] as $keyProp => $valProp) {

                            //call_user_func(array("\App\\".$arrOldNameProps[$keyPropEl], "firstOrCreate"),
                            //    ["name"           => $valParseCatalog[$keyPropEl]["ALL_NAME"][$keyProp],
                    		//    "code"           => $valProp,
                            //     "description"    => $desc = empty($valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp]) ? null : $valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp]]
                            //);

                            $explodeValue = explode("|",$arrOldNameProps[$keyPropEl]);
                            $className = "\App\\".$explodeValue[0];
                            $addProp = $className::firstOrCreate(
                    		    ["name"           => $valParseCatalog[$keyPropEl]["ALL_NAME"][$keyProp],
                    		     "code"           => $valProp,
                    		     "description"    => $desc = empty($valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp]) ? null : $valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp]]
                    		);

                            //$arrT = array(
                            //    "name"          => $valParseCatalog[$keyPropEl]["ALL_NAME"][$keyProp],
                            //    "code"          => $valProp,
                            //    "description"   => $desc = empty($valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp]) ? null : $valParseCatalog[$keyPropEl]["ALL_DESCRIPTION"][$keyProp],
                            //);

                            foreach ($valParseCatalog[$keyPropEl]["VALUE"] as $valEl) {
                                if ($valEl == $valProp) {
                                    $codeProp[$explodeValue[0]."|".$explodeValue[1]][] = $addProp->code;
                                }
                            }

                        }
                    }

                }

            }


            if (isset($valParseCatalog["PLOCHAD"]) && $valParseCatalog["PLOCHAD"] != "") {
                $valParseCatalog["PLOSHAD"] = $valParseCatalog["PLOCHAD"];
            }
            if (isset($valParseCatalog["PLOCHAD_KVARTIRY"]) && $valParseCatalog["PLOCHAD_KVARTIRY"] != "") {
                $valParseCatalog["PLOSHAD"] = $valParseCatalog["PLOCHAD_KVARTIRY"];
            }
            if (isset($valParseCatalog["RASSR"]) && $valParseCatalog["RASSR"] != "") {
                $valParseCatalog["RASSROCH"] = $valParseCatalog["RASSR"];
            }
            if (isset($valParseCatalog["SEE_MORE_LIST_XML_ID"]) && $valParseCatalog["SEE_MORE_LIST_XML_ID"] != "" && $valParseCatalog["SEE_MORE_LIST_XML_ID"] == "Y") {
                $valParseCatalog["SEE_MORE"] = 1;
            }
            if (isset($valParseCatalog["SEE_GORI_LIST_XML_ID"]) && $valParseCatalog["SEE_GORI_LIST_XML_ID"] != "" && $valParseCatalog["SEE_GORI_LIST_XML_ID"] == "Y") {
                $valParseCatalog["SEE_GORI"] = 1;
            }
            if (isset($valParseCatalog["GAZ_LIST_XML_ID"]) && $valParseCatalog["GAZ_LIST_XML_ID"] != "" && $valParseCatalog["GAZ_LIST_XML_ID"] == "Y") {
                $valParseCatalog["GAZ"] = 1;
            }
            if (isset($valParseCatalog["IPOTEKA_LIST_XML_ID"]) && $valParseCatalog["IPOTEKA_LIST_XML_ID"] != "" && $valParseCatalog["IPOTEKA_LIST_XML_ID"] == "Y") {
                $valParseCatalog["IPOTEKA"] = 1;
            }
            if (isset($valParseCatalog["MATKAP_LIST_XML_ID"]) && $valParseCatalog["MATKAP_LIST_XML_ID"] != "" && $valParseCatalog["MATKAP_LIST_XML_ID"] == "Y") {
                $valParseCatalog["MATKAP"] = 1;
            }
            if (isset($valParseCatalog["RASSR_LIST_XML_ID"]) && $valParseCatalog["RASSR_LIST_XML_ID"] != "" && $valParseCatalog["RASSR_LIST_XML_ID"] == "Y") {
                $valParseCatalog["RASSROCH"] = 1;
            }
            if (isset($valParseCatalog["VTORICH_LIST_XML_ID"]) && $valParseCatalog["VTORICH_LIST_XML_ID"] != "" && $valParseCatalog["VTORICH_LIST_XML_ID"] == "Y") {
                $valParseCatalog["VTORICH"] = 1;
            }
            if (isset($valParseCatalog["CHEKERB_ELEMENT"]) && $valParseCatalog["CHEKERB_ELEMENT"] != "") {
                $valParseCatalog["ETAZHEI"] = $valParseCatalog["CHEKERB_ELEMENT"];
            }
            if (isset($valParseCatalog["PRICE_FULL2"]) && $valParseCatalog["PRICE_FULL2"] != "") {
                $valParseCatalog["PRICE2"] = $valParseCatalog["PRICE_FULL2"];
            }

            if (isset($valParseCatalog["EHTAZHEJ"]) && $valParseCatalog["EHTAZHEJ"] != "") {
                $valParseCatalog["ETAZHEI"] = $valParseCatalog["EHTAZHEJ"];
            }
            if (isset($valParseCatalog["EHTAZHNOST"]) && $valParseCatalog["EHTAZHNOST"] != "") {
                $valParseCatalog["ETAZHEI"] = $valParseCatalog["EHTAZHNOST"];
            }
            if (isset($valParseCatalog["EHTAZH"]) && $valParseCatalog["EHTAZH"] != "") {
                $valParseCatalog["ETAZH"] = $valParseCatalog["EHTAZH"];
            }

            if (isset($valParseCatalog["VYSOTA_POTOLKOV"]) && $valParseCatalog["VYSOTA_POTOLKOV"] != "") {
                $valParseCatalog["VISOTA_P"] = $valParseCatalog["VYSOTA_POTOLKOV"];
            }
            if (isset($valParseCatalog["RASSTOYANIE_DO_MORYA"]) && $valParseCatalog["RASSTOYANIE_DO_MORYA"] != "") {
                $valParseCatalog["DO_MORE"] = $valParseCatalog["RASSTOYANIE_DO_MORYA"];
            }
            if (isset($valParseCatalog["MATERINSKIJ_KAPITAL"]) && $valParseCatalog["MATERINSKIJ_KAPITAL"] != "") {
                $valParseCatalog["MATKAP"] = $valParseCatalog["MATERINSKIJ_KAPITAL"];
            }
            if (isset($valParseCatalog["VOZMOZHNA_RASSROCHKA"]) && $valParseCatalog["VOZMOZHNA_RASSROCHKA"] != "") {
                $valParseCatalog["RASSROCH"] = $valParseCatalog["VOZMOZHNA_RASSROCHKA"];
            }
            if (isset($valParseCatalog["KOLICHESTV_SAN_UZLOV"]) && $valParseCatalog["KOLICHESTV_SAN_UZLOV"] != "") {
                $valParseCatalog["SANUZ_Q"] = $valParseCatalog["KOLICHESTV_SAN_UZLOV"];
            }
            if (isset($valParseCatalog["PROBLEMO"]) && $valParseCatalog["PROBLEMO"] != "") {
                $valParseCatalog["PROBLEMO_LIST_VALUE"] = $valParseCatalog["PROBLEMO"];
            }
            if (isset($valParseCatalog["VID_NA_MORE"]) && $valParseCatalog["VID_NA_MORE"] != "") {
                $valParseCatalog["SEE_MORE"] = $valParseCatalog["VID_NA_MORE"];
            }
            if (isset($valParseCatalog["VID_NA_GORY"]) && $valParseCatalog["VID_NA_GORY"] != "") {
                $valParseCatalog["SEE_GORI"] = $valParseCatalog["VID_NA_GORY"];
            }

            if (isset($valParseCatalog["NOVOSTROJKA_ELEM_NAME"]) && $valParseCatalog["NOVOSTROJKA_ELEM_NAME"] != "") {
                $idCottageVillage = Catalog::where("code", $valParseCatalog["NOVOSTROJKA_ELEM_CODE"])->first();
            }

            if (isset($valParseCatalog["ZHSK_ELEM_NAME"]) && $valParseCatalog["ZHSK_ELEM_NAME"] != "") {
                $idGsk = Catalog::where("name", $valParseCatalog["ZHSK_ELEM_NAME"])->first();
            }

            //add element
            $addElement = Catalog::firstOrCreate(
                ["basic_section"        => $basic_section = empty($mainSectionElement) ? $addIblock->id : $mainSectionElement,
                 "active"               => 1,
                 "name"                 => $name = empty($valParseCatalog["NAME"]) ? null : $valParseCatalog["NAME"],
                 "code"                 => $code = empty($valParseCatalog["CODE"]) ? null : $valParseCatalog["CODE"],
                 "preview_text"         => $previewText = empty($valParseCatalog["PREVIEW_TEXT"]) ? null : $valParseCatalog["PREVIEW_TEXT"],
                 "preview_picture"      => $previewPicture = empty($valParseCatalog["PREVIEW_PICTURE"]) ? null : $valParseCatalog["PREVIEW_PICTURE"],
                 "detail_text"          => $detailText = empty($valParseCatalog["DETAIL_TEXT"]) ? null : $valParseCatalog["DETAIL_TEXT"],
                 "area"                 => $area = empty($valParseCatalog["PLOSHAD"]) ? null : $valParseCatalog["PLOSHAD"],
                 "price"                => $price = empty($valParseCatalog["PRICE"]) ? null : $valParseCatalog["PRICE"],
                 "old_price"            => $oldPrice = empty($valParseCatalog["OLD_PRICE"]) ? null : $valParseCatalog["OLD_PRICE"],
                 "price_m"              => $priceM = empty($valParseCatalog["PRICE_M2"]) ? null : $valParseCatalog["PRICE_M2"],
                 "floors"               => $floors = empty($valParseCatalog["ETAZHEI"]) ? null : $valParseCatalog["ETAZHEI"],
                 "floor"                => $floor = empty($valParseCatalog["ETAZH"]) ? null : $valParseCatalog["ETAZH"],
                 "height_ceiling"       => $heightCeiling = empty($valParseCatalog["VISOTA_P"]) ? null : $valParseCatalog["VISOTA_P"],
                 "garage"               => $garage = empty($valParseCatalog["GARAZH"]) ? null : $valParseCatalog["GARAZH"],
                 "to_sea"               => $toSea = empty($valParseCatalog["DO_MORE"]) ? null : $valParseCatalog["DO_MORE"],
                 "see_sea"              => $seeSea = empty($valParseCatalog["SEE_MORE"]) ? null : $valParseCatalog["SEE_MORE"],
                 "see_mountains"        => $seeMountains = empty($valParseCatalog["SEE_GORI"]) ? null : $valParseCatalog["SEE_GORI"],
                 "number_bathrooms"     => $numberBathrooms = empty($valParseCatalog["SANUZ_Q"]) ? null : $valParseCatalog["SANUZ_Q"],
                 "installment"          => $installment = empty($valParseCatalog["RASSROCH"]) ? null : $valParseCatalog["RASSROCH"],
                 "amount_commission"    => $amountCommission = empty($valParseCatalog["RAZMER_COMM"]) ? null : $valParseCatalog["RAZMER_COMM"],
                 "secondary"            => $secondary = empty($valParseCatalog["VTORICH"]) ? null : $valParseCatalog["VTORICH"],
                 "reason_rejection"     => $reasonRejection = empty($valParseCatalog["WHYNOT"]) ? null : $valParseCatalog["WHYNOT"],
                 "verification_date"    => $verificationDate = empty($valParseCatalog["CHECKDATE"]) ? null : $valParseCatalog["CHECKDATE"],
                 "contacts_seller"      => $contactsSeller = empty($valParseCatalog["MNG_CONTACTP"]) ? null : $valParseCatalog["MNG_CONTACTP"],
                 "yandex_coord"         => $yandexCoord = empty($valParseCatalog["MAPYANDEX"]) ? null : $valParseCatalog["MAPYANDEX"],
                 "seo_title"            => $seoTitle = empty($valParseCatalog["MY_SEO_TITLE"]) ? null : $valParseCatalog["MY_SEO_TITLE"],
                 "text_action"          => $textAction = empty($valParseCatalog["PROMO_TEXT"]) ? null : $valParseCatalog["PROMO_TEXT"],
                 "street"               => $street = empty($addStreet->id) ? null : $addStreet->id,
                 "status_sale"          => $status = empty($addStatus->id) ? null : $addStatus->id,
                 "price_ap_min"         => $price_from = empty($valParseCatalog["PRICE_FULL"]) ? null : $valParseCatalog["PRICE_FULL"],
                 "price_ap_max"         => $price_to = empty($valParseCatalog["PRICE2"]) ? null : $valParseCatalog["PRICE2"],
                 "number_houses"        => $number_houses = empty($valParseCatalog["VSEGO_DOMOV"]) ? null : $valParseCatalog["VSEGO_DOMOV"],
                 "number_apartments"    => $number_houses = empty($valParseCatalog["VSEGO_KVARTIR"]) ? null : $valParseCatalog["VSEGO_KVARTIR"],
                 "cost_service"         => $cost_service = empty($valParseCatalog["STOIMOST_OBSLUZHIVANIYA"]) ? null : $valParseCatalog["STOIMOST_OBSLUZHIVANIYA"],
                 "place_from"           => $place_from = empty($valParseCatalog["PLACE"]) ? null : $valParseCatalog["PLACE"],
                 "place_to"             => $place_to = empty($valParseCatalog["PLACE_2"]) ? null : $valParseCatalog["PLACE_2"],
                 "gaz"                  => $gaz = empty($valParseCatalog["GAZ"]) ? null : $valParseCatalog["GAZ"],
                 "mortgage"             => $mortgage = empty($valParseCatalog["IPOTEKA"]) ? null : $valParseCatalog["IPOTEKA"],
                 "federal_law_214"      => $low_214 = empty($valParseCatalog["FEDERALNYJ_ZAKON_214"]) ? null : $valParseCatalog["FEDERALNYJ_ZAKON_214"],
                 "federal_law_215"      => $low_215 = empty($valParseCatalog["FEDERALNYJ_ZAKON_215"]) ? null : $valParseCatalog["FEDERALNYJ_ZAKON_215"],
                 "m_capital"            => $m_capital = empty($valParseCatalog["MATKAP"]) ? null : $valParseCatalog["MATKAP"],
                 "area_ap_min"          => $area_ap_min = empty($valParseCatalog["PLOSHCHAD_KVARTIR_MIN"]) ? null : $valParseCatalog["PLOSHCHAD_KVARTIR_MIN"],
                 "area_ap_max"          => $area_ap_max = empty($valParseCatalog["PLOSHCHAD_KVARTIR_MAX"]) ? null : $valParseCatalog["PLOSHCHAD_KVARTIR_MAX"],
                 "infrastructure"       => $infrastructure = empty($valParseCatalog["INFRASTRUCTURA"]) ? null : $valParseCatalog["INFRASTRUCTURA"],
                 "for_dacha"            => $for_dacha = empty($valParseCatalog["FOR_DACH"]) ? null : $valParseCatalog["FOR_DACH"],
                 "for_build"            => $for_build = empty($valParseCatalog["FOR_STRO"]) ? null : $valParseCatalog["FOR_STRO"],
                 "price_hundred"        => $price_hundred = empty($valParseCatalog["PRICE_SOT"]) ? null : $valParseCatalog["PRICE_SOT"],
                 "problem_obj"          => $problem_obj = empty($valParseCatalog["PROBLEMO_LIST_VALUE"]) ? null : $valParseCatalog["PROBLEMO_LIST_VALUE"],
                 "home_show"            => $home_show = empty($valParseCatalog["HOME_SEE"]) ? null : $valParseCatalog["HOME_SEE"],
                 "home_readiness"       => $home_finish = empty($valParseCatalog["GOTOVNOST_DOMA_LIST_VALUE"]) ? null : $valParseCatalog["GOTOVNOST_DOMA_LIST_VALUE"],
                 "type_building"        => $type_building = empty($valParseCatalog["TIP_ZDANIYA_LIST_VALUE"]) ? null : $valParseCatalog["TIP_ZDANIYA_LIST_VALUE"],
                 "developer_buildings"  => $developer_buildings = empty($valParseCatalog["ZASTROJSHCHIK_ELEM_NAME"]) ? null : $valParseCatalog["ZASTROJSHCHIK_ELEM_NAME"],
                 "apartments_sea_view"  => $apartments_sea_view = empty($valParseCatalog["KVARTIRY_S_VIDOM_NA_MORE"]) ? null : $valParseCatalog["KVARTIRY_S_VIDOM_NA_MORE"],
                 "apartments_mount_view"=> $apartments_mount_view = empty($valParseCatalog["KVARTIRY_S_VIDOM_NA_GORY"]) ? null : $valParseCatalog["KVARTIRY_S_VIDOM_NA_GORY"],
                 "status_real_estates"  => $status_real_estates = empty($valParseCatalog["STATUS_NEDVIZHIMOSTI_LIST_VALUE"]) ? null : $valParseCatalog["STATUS_NEDVIZHIMOSTI_LIST_VALUE"],
                 "video"                => $video = empty($valParseCatalog["VIDEO_INPUT"]) ? null : $valParseCatalog["VIDEO_INPUT"],
                 "include"              => $include = empty($valParseCatalog["INCLUDE"]) ? null : $valParseCatalog["INCLUDE"],
                 "military_mortgage"    => $military_mortgage = empty($valParseCatalog["MIL_IPOTEKA"]) ? null : $valParseCatalog["MIL_IPOTEKA"],
                 "profit"               => $profit = empty($valParseCatalog["TOP_LIST_VALUE"]) ? null : $valParseCatalog["TOP_LIST_VALUE"],
                 "size_remuneration"    => $size_remuneration = empty($valParseCatalog["MNG_RAZMERV"]) ? null : $valParseCatalog["MNG_RAZMERV"],
                 "cottage_village"      => $cottage_village = empty($idCottageVillage->id) ? null : $idCottageVillage->id,
                 "gsk"                  => $gsk = empty($idGsk->id) ? null : $idGsk->id
                ]
            );
            // add relations directory with element
            foreach ($codeProp as $keyCodeProp => $valCodeProp) {
                $explodeProp = explode("|", $keyCodeProp);
                foreach ($valCodeProp as $keyProp => $valProp) {
                    $addDirectory = ElementDirectory::firstOrCreate(
                        [
                            "name_table"    => $explodeProp[0],
                            "name_field"    => $explodeProp[1],
                            "element_id"    => $addElement->id,
                            "code"          => $valProp,
                        ]
                    );
                }
            }

            // update picture, set id element
            foreach ($idPhotos as $keyId => $valId) {
                $finalPicture = Picture::where("id", $valId)->update(["element_id" => $addElement->id]);
            }

            // update picture, set id element
            foreach ($idLayout as $keyId => $valId) {
                $finalPicture = Layout::where("id", $valId)->update(["element_id" => $addElement->id]);
            }

            // update picture, set id element
            foreach ($idPlanFloor as $keyId => $valId) {
                $finalPicture = PlanFloor::where("id", $valId)->update(["element_id" => $addElement->id]);
            }

            if (!empty($sectionElement)) {
                // add section element
                foreach ($sectionElement as $keySecEl => $valSecEl) {
                    $elemsSection = CatalogsElement::firstOrCreate(
                        [
                            "parent_id"     => $valSecEl,
                            "element_id"    => $addElement->id,
                        ]
                    );
                }
            } else {
                $elemsSection = CatalogsElement::firstOrCreate(
                    [
                        "parent_id"     => $addIblock->id,
                        "element_id"    => $addElement->id,
                    ]
                );
            }

            if (!empty($valParseCatalog["CHEKERB_SECTION"])) {
                $explodeChess = explode("|", $valParseCatalog["CHEKERB_SECTION"]);
                if (!empty($explodeChess[0])) {
                    $chess = Chess::firstOrCreate(
                        [
                            "element_id"        => $addElement->id,
                            "section_list"      => $explodeChess[0],
                            "section_name"      => $explodeChess[1],
                            "section_lenght"    => $valParseCatalog["CHEKERB_ELEMENT"],
                        ]
                    );
                }
            }

            $allCatalogEL = Builder::all();

            foreach ($allCatalogEL as $keyEl => $valEl) {
                $allEl = Catalog::where("developer_buildings", $valEl->name)->get();
                foreach ($allEl as $val) {
                    Catalog::where("id", $val->id)->update(["developer_buildings" => $valEl->id]);
                }
            }

            //chess in table
            if (!empty($valParseCatalog["CHEKERB_ELEM"])) {
                $explodeChessItem = explode("|", $valParseCatalog["CHEKERB_BIG"]);

                if (!empty($explodeChessItem[0])) {
                    $chessItem = Chess::firstOrCreate(
                        [
                            "element_id"        => $addElement->id,
                            "old_obj"           => $valParseCatalog["CHEKERB_ELEM"],
                            "old_width"         => $explodeChessItem[0],
                            "old_height"        => $explodeChessItem[1],
                        ]
                    );
                } else {
                    $chessItem = Chess::firstOrCreate(
                        [
                            "element_id"        => $addElement->id,
                            "old_obj"           => $valParseCatalog["CHEKERB_ELEM"],
                        ]
                    );
                }

            }

        }

    }

}
