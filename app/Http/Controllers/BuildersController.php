<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

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
        $finalArray = [];
        $builderList = Builder::orderBy("name", "asc")
                              ->get()
                              ->toArray();

        foreach ($builderList as $keyBuilderList => $valBuilderList) {
            $finalArray[mb_substr($valBuilderList["name"], 0, 1)][] = $builderList[$keyBuilderList];
        }

        // SEO information
        Helper::setSEO(
            "Застройщики Сочи, официальная информация о застройщиках в Сочи",
            "Белый список застройщиков Сочи. Объекты и актуальная информация о скидках и акциях.",
            URL::current()
        );

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

        $request = [
            "ar_filter"     => ["developer_buildings" => $builderItem->id],
            "ar_select"     => ["id", "basic_section", "name", "code", "text_action", "price_ap_min"]
        ];

        $elements = ApiController::getCatalog($request);

        // SEO information
        Helper::setSEO(
            "Застройщик ".$builderItem->name." и информация о нем",
            "Все новостройки от застройщика ".$builderItem->name." в Сочи - информация о ценах, планировках и документах на строительство.",
            "http://sunsochi.goodcode.ru"
        );

        return view("builder-detail", [
            "builderItem"  => $builderItem,
            "builderOffers" => $elements,
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
