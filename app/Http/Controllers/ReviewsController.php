<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Http\Request;

use App\GoodCode\ParseCsv;
use App\GoodCode\Helper;

use App\Review;

use Session;
use Excel;
use File;


class ReviewsController extends Controller
{

    // index page
    public function index() {

        // SEO information
        Helper::setSEO(
            "Отзывы клиентов",
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            URL::current()
        );

        $reviewList = Review::orderBy("date", "asc")->paginate(3);

        foreach ($reviewList as $keyList => $valList) {
            $finalText = Helper::splitText($valList->text, 50);
            $valList->textOther = $finalText[0];
            $valList->text = $finalText[1];
        }

        return view("reviews-list", [
            "reviewList"    => $reviewList,
            "pageTitle"     => "Отзывы",
        ]);

    }

    // import page
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
                        "name"              => $value["IE_NAME"],
                        "date"              => date_format(date_create($value["IE_ACTIVE_FROM"]), "Y-m-d H:i:s"),
                        "text"              => trim(preg_replace('/\s{2,}/', ' ', $value["IE_DETAIL_TEXT"])),
                        "autor"             => $value["IE_NAME"],
                        "from"              => $value["IP_PROP71"],
                        "picture"           => $value["IE_PREVIEW_PICTURE"],
                        "video"             => $value["IP_PROP72"],
                        "url"               => $value["IE_CODE"],
                    ];
                }
                if(!empty($insert)){
                    $insertData = DB::table("reviews")->insert($insert);
                    if ($insertData) {
                        Session::flash("success", "Your Data has successfully imported");
                    } else {
                        Session::flash("error", "Error inserting the data..");
                        return back();
                    }
                }
            }

            //return back();

        } else {
            Session::flash("error", "File is a ".$expanFile. "file.!! Please upload a valid xls/csv file..!!");
        }

    }

}
