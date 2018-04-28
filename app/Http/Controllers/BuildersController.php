<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

use App\GoodCode\ParseCsv;
use App\GoodCode\Helper;

use App\Builder;
use App\Catalog;
use App\CatalogsSection;
use App\CatalogsElement;
use App\ElementDirectory;
use App\District;
use App\Picture;
use App\NumberRoom;
use App\Deadline;

use Session;
use Excel;
use File;

class BuildersController extends Controller
{
    // index page
    public function index() {

        // SEO information
        Helper::setSEO(
            "Застройщики Сочи, официальная информация о застройщиках в Сочи",
            "Белый список застройщиков Сочи. Объекты и актуальная информация о скидках и акциях.",
            "http://sunsochi.goodcode.ru"
        );

        $finalArray = [];
        $builderList = Builder::orderBy("name", "asc")->get()->toArray();

        foreach ($builderList as $keyBuilderList => $valBuilderList) {
            $finalArray[mb_substr($valBuilderList["name"], 0, 1)][] = $builderList[$keyBuilderList];
        }

        return view("builders-list", [
            "builderList"  => $finalArray,
            "pageTitle" => "Застройщики",
            "pageSubtitle" => "Мы собрали для вас информацию по всем компаниям-застройщикам, которые занимаются строительством жилых комплексов в городе-курорте Сочи."
        ]);

    }

    // detail page
    public function show($code) {
        $builderItem = Builder::where("code", $code)->first();

        if (!isset($builderItem)) {
            return redirect(404);
        }

        $builderOffers = Catalog::select("id", "basic_section", "name", "code", "text_action", "price_from")
                                ->where("developer_buildings", $builderItem->id)
                                ->orderBy("active", "1")
                                ->orderBy("name", "asc")
                                ->paginate(6);

        // SEO information
        Helper::setSEO(
            "Застройщик ".$builderItem->name." и информация о нем",
            "Все новостройки от застройщика ".$builderItem->name." в Сочи - информация о ценах, планировках и документах на строительство.",
            "http://sunsochi.goodcode.ru"
        );

        if (!$builderOffers->isEmpty()) {

            foreach ($builderOffers as $keyOffers => $valOffers) {

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

                    if (isset($districtProp)) {
                        $district = District::select("name")
                                            ->where("code", $districtProp->code)
                                            ->first();
                    } else {
                        $district->{"name"} = "";
                    }

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
                    $builderOffers[$keyOffers]->{"photo"}       = $photo->path;
                    $builderOffers[$keyOffers]->{"district"}    = $district->name;
                    $builderOffers[$keyOffers]->{"deadline"}    = $deadline->name;
                    $builderOffers[$keyOffers]->{"apartments"}  = (object)$apartmnetItems;
                    $builderOffers[$keyOffers]->{"path"}        = route("CatalogShow", [$catalogSection->code, $subSection->code, $valOffers->code]);

                }

            }

        }

        return view("builder-detail", [
            "builderItem"  => $builderItem,
            "builderOffers" => $builderOffers,
            "pageTitle" => $builderItem->name
        ]);

    }

    // import page
    public function import() {
        return view("import", ["action" => route("BuildersImportSend")]);
    }

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
        while (($readFile = fgetcsv($fileOpen, 100000, ";")) !== FALSE ) {
            foreach ($readFile as $keyreadFile => $valreadFile) {
                $readFile[$keyreadFile] = $valreadFile;
            }
            $arrReadFile[] = $readFile;
        }

        $data = ParseCsv::parsingCsv($arrReadFile);

        if ($expanFile == "csv") {
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        "name"    => $value["IE_NAME"],
                        "url"     => $value["IE_CODE"],
                        "logo"    => $value["IE_DETAIL_PICTURE"],
                        "text"    => $value["IE_DETAIL_TEXT"],
                    ];
                }

                if(!empty($insert)){
                    $insertData = DB::table("builders")->insert($insert);
                    if ($insertData) {
                        Session::flash("success", "Your Data has successfully imported");
                    } else {
                        Session::flash("error", "Error inserting the data..");
                        return back();
                    }
                }

            }

            return back();

        } else {
            Session::flash("error", "File is a ".$expanFile. "file.!! Please upload a valid xls/csv file..!!");
        }

    }

}
