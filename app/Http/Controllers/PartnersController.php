<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\GoodCode\ParseCsv;
use App\GoodCode\Helper;

use App\Partner;

use Session;
use Excel;
use File;

use SEO;

class PartnersController extends Controller
{
    public function index() {
        // SEO information
        Helper::setSEO(
            "Наши партнеры",
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            "http://sunsochi.goodcode.ru"
        );

        $partnersList = Partner::orderBy("name", "asc")->get();

        return view("partners", [
            "partnersList"  => $partnersList,
            "pageTitle" => "Партнеры"
        ]);

    }

    public function import() {
        return view("import", ["action" => route("PartnersImportSend")]);
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
                        "link"    => $value["IP_PROP334"],
                        "logo"    => $value["IE_PREVIEW_PICTURE"],
                        "text"    => $value["IE_PREVIEW_TEXT"],
                        "url"     => $value["IE_CODE"],
                    ];
                }
                if(!empty($insert)){
                    $insertData = DB::table("partners")->insert($insert);
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
