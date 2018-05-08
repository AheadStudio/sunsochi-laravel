<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

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


    //-- CATALOG BLOG --//

    public function getCatalog(Request $request) {
        $inputs = $request->all();
        // get sections which belong to elements
        $arSections = [];

        if (isset($inputs["novostroyki_v_sochi_po_fz_214"]) && $inputs["novostroyki_v_sochi_po_fz_214"] == "on") {
            $result = CatalogsSection::where("code", "novostroyki_v_sochi_po_fz_214")->first();
            $dataRequest[] = ["parent_id", $result->id];
        }
        if (isset($inputs["sdannye_novostroyki_v_sochi"]) && $inputs["sdannye_novostroyki_v_sochi"] == "on") {
            $result = CatalogsSection::where("code", "sdannye_novostroyki_v_sochi")->first();
            $dataRequest[] = ["parent_id", $result->id];
        }
        if (isset($inputs["novostroyki_pod_ipoteku"]) && $inputs["novostroyki_pod_ipoteku"] == "on") {
            $result = CatalogsSection::where("code", "novostroyki_pod_ipoteku")->first();
            $dataRequest[] = ["parent_id", $result->id];
        }
        if (isset($inputs["novostroyki_u_morya"]) && $inputs["novostroyki_u_morya"] == "on") {
            $result = CatalogsSection::where("code", "novostroyki_u_morya")->first();
            $dataRequest[] = ["parent_id", $result->id];
        }

        if (!empty($dataRequest)) {
            $idElements = CatalogsElement::where("parent_id", $dataRequest[0][1])
                                         ->take(5)
                                         ->get();
        }

        foreach ($idElements as $key => $val) {
            $elements = Catalog::select("id", "basic_section", "name", "code", "text_action", "price_from")
                                  ->where("basic_section", $dataRequest[0][1])
                                  ->orderBy("active", "1")
                                  ->orderBy("name", "asc")
                                  ->paginate(6);
        }

        if ($elements) {

            foreach ($elements as $keyOffers => $valOffers) {

                if (!empty($valOffers) || isset($valOffers)) {

                    // get section offers
                    $subSection = CatalogsSection::select("parent_id", "code")
                                                 ->where("id", $valOffers->basic_section)
                                                 ->first();

                    $catalogSection = CatalogsSection::select("code")
                                                     ->where("id", $subSection->parent_id)
                                                     ->first();

                    // get photo offers
                    $photo = Picture::select("path")
                                    ->where("element_id", $valOffers->id)
                                    ->first();

                    // get district(region) offers
                    $districtProp = ElementDirectory::where("element_id", $valOffers->id)
                                                    ->where("name_field", "district")
                                                    ->first();
                    $district = new \stdClass();

                    if (isset($districtProp)) {
                        $district = District::select("name")
                                            ->where("code", $districtProp->code)
                                            ->first();
                    } else {
                        $district->{"name"} = "";
                    }

                    $deadline = new \stdClass();

                    // get end of construction
                    $deadlineProp = ElementDirectory::where("element_id", $valOffers->id)
                                                    ->where("name_field", "deadline")
                                                    ->first();
                    if (isset($deadlineProp->code)) {
                        $deadline = Deadline::select("name")
                                            ->where("code", $deadlineProp->code)
                                            ->first();
                    } else {
                        $deadline->{"name"} = "";
                    }

                    //using Cache
                    $apartments = Cache::remember("catalogApartments", 24*60, function() use(&$valOffers){
                        return Catalog::select("id", "price")
                                             ->where([
                                                ["cottage_village", $valOffers->id],
                                                ["price", ">", "0"],
                                             ])
                                             ->orderBy("price", "asc")
                                             ->distinct()
                                             ->get();
                    });

                    $apartmnetItems = [];

                    foreach ($apartments as $keyApartment => $valApartment) {
                        $apartmentsProp = ElementDirectory::where([
                                                             ["element_id", $valApartment->id],
                                                             ["name_field", "number_rooms"],
                                                          ])
                                                          ->first();

                        if (!empty($apartmentsProp->code) || isset($apartmentsProp->code)) {
                            $apartmentRooms = NumberRoom::where("code", $apartmentsProp->code)->first();

                            // verification of existence apartments
                            if(!isset($apartmnetItems[$apartmentRooms->name])) {
                                $apartmnetItems[$apartmentRooms->name] = Array(
                                    "price" => $valApartment->price
                                );
                            } else {
                                if($apartmnetItems[$apartmentRooms->name]->price > $valApartment->price) {
                                    $apartmnetItems[$apartmentRooms->name]->price = $valApartment->price;
                                }
                            }

                            // convert array to object (for unification component)
                            $apartmnetItems = array_map(function($array){
                                return (object)$array;
                            }, $apartmnetItems);

                        } else {
                            $apartmnetItems = [];
                        }
                    }

                    ksort($apartmnetItems);


                    // create final object
                    if (isset($photo->path)) {
                        $valOffers->{"photo"} = $photo->path;
                    } else {
                        $valOffers->{"photo"} = "";
                    }
                    $elements[$keyOffers]->{"district"}    = $district->name;
                    $elements[$keyOffers]->{"deadline"}    = $deadline->name;
                    $elements[$keyOffers]->{"apartments"}  = (object)$apartmnetItems;
                    $elements[$keyOffers]->{"path"}        = route("CatalogShow", [$catalogSection->code, $subSection->code, $valOffers->code]);

                }

            }

        }
        $pageParams = [];
        $pageParams["pageTitle"] = "Новостройки Сочи и Адлера";
        $pageParams["pageTabs"] = ["Вcе объекты проверены", "Квартиры<br>от 900 тысяч<br>рублей", "Гарантия цены<br>застройщика"];
        $pageParams["pageImage"] = "/dummy/new-bildings.jpg";

        $pageParams["district"] = Cache::remember("catalogDistrict", 24*60, function() {
            return District::select("code", "name")->get();
        });
        $pageParams["offers"] = $elements;

        return view("catalog/section", $pageParams);

    }

    //-- //CATALOG BLOG --//
}
