<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GoodCode\ParseCsv;

use \App\News;

use Session;
use Excel;
use File;

class NewsController extends Controller
{
    // index page
    public function index() {
        $newsList = News::orderBy("date", "asc")->paginate(3);
        return view("news-list", [
            "newsList"  => $newsList,
            "pageTitle" => "Новости"
        ]);
    }

    // detail page
    public function show($code) {
        $newsItem = News::where("code", $code)->first();
        return view("news-detail", [
            "newsItem"  => $newsItem,
            "pageTitle" => $newsItem->name
        ]);
    }

    // import page
    public function import() {
        return view("import", ["action" => route("NewsImportSend")]);
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

        if ($expanFile == "csv") {
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    $insert[] = [
                        "name"              => $value["IE_NAME"],
                        "date"              => date_format(date_create($value["IE_ACTIVE_FROM"]), "Y-m-d H:i:s"),
                        "url"               => $value["IE_CODE"],
                        "preview_text"      => $value["IE_PREVIEW_TEXT"],
                        "preview_picture"   => $value["IE_PREVIEW_PICTURE"],
                        "detail_text"       => trim(preg_replace('/\s{2,}/', ' ', $value["IE_DETAIL_TEXT"])),
                    ];
                }

                if(!empty($insert)){
                    $insertData = DB::table("news")->insert($insert);
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
