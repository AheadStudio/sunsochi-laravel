<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GoodCode\ParseCsv;

use \App\Team;

use Session;
use Excel;
use File;

class TeamController extends Controller
{
    public function index() {
        $finalArray = [];
        $teamList = Team::orderBy("section", "asc")->get()->toArray();
        foreach ($teamList as $keyTeamList => $valTeamList) {
            $finalArray[$valTeamList["section"]][] = $teamList[$keyTeamList];
        }
        return view("team", [
            "teamList" => $finalArray,
            "pageTitle"    => "Сотрудники"
        ]);
    }

    public function import() {
        return view("import", ["action" => route("TeamImportSend")]);
    }

    public function importHandler(Request $request) {
        $this->validate($request, array(
            "file"  =>  "required"
        ));

        $file = $request->file;

        // folder download
        $destinationPath = "uploads";

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
                        "name"     =>  $value["IE_NAME"],
                        "section"  =>  $value["IC_GROUP0"],
                        "url"      =>  $value["IE_CODE"],
                        "post"     =>  $value["IP_PROP273"],
                        "mobile"   =>  $value["IP_PROP274"],
                        "email"    =>  $value["IP_PROP275"],
                        "logo"     =>  $value["IE_PREVIEW_PICTURE"],
                    ];
                }

                if(!empty($insert)){
                    $insertData = DB::table("teams")->insert($insert);
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
