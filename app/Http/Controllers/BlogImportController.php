<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Session;
use Excel;
use File;

class BlogImportController extends Controller
{
    public function index() {
        return view("import-table");
    }

    public function import(Request $request) {
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
		while (($readFile = fgetcsv($fileOpen, 1000, ";")) !== FALSE ) {
			foreach ($readFile as $keyreadFile => $valreadFile) {
				$readFile[$keyreadFile] = $valreadFile;
			}
			$arrReadFile[] = $readFile;
		}

        $data = $this->parsingCsv($arrReadFile);

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
                        "views"             => 0,
                    ];
                }
                
                if(!empty($insert)){
                    $insertData = DB::table("blogs")->insert($insert);
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

    public function parsingCsv($arrayDataCsv) {
        //final array
        $finalArray = [];

        // name field from csv
        $nameField = array_shift($arrayDataCsv);

        // merger two arrays in final array
        foreach ($arrayDataCsv as $keyData => $valData) {
            foreach ($nameField as $keyNameField => $valNameField) {
                $finalArray[$keyData][$valNameField] = $arrayDataCsv[$keyData][$keyNameField];
            }
        }
        return $finalArray;
    }

}
