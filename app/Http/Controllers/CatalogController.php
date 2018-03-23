<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\GoodCode\ParseCsv;

use App\Catalog;
use Session;
use Excel;
use File;


class CatalogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
    	return view("catalog.index");
    }


    public function section(Request $request, $section) {
	    $objects = Catalog::getList();
        $route = $request->url();
	    return view("catalog/section")->with(
		    Array(
			    "objects" => $objects,
			    "title" => "Catalog page",
                "section" => $section,
                "route" => $route,
		    )
	    );
    }



    public function detail($section, $code) {
	   return view("catalog/detail");

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function show(Catalog $catalog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function edit(Catalog $catalog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Catalog $catalog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Catalog  $catalog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Catalog $catalog)
    {
        //
    }

    public function import() {
        return view("import", ["action" => route("CatalogImportSend")]);
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
        while (($readFile = fgetcsv($fileOpen, 100000, ";")) !== FALSE) {
            foreach ($readFile as $keyreadFile => $valreadFile) {
                $readFile[$keyreadFile] = $valreadFile;
            }
            $arrReadFile[] = $readFile;
        }

        $nameField = array_shift($arrReadFile);
        $finalArray = [];
        $resultArray = [];
        $fakeArray = $arrReadFile;

        // parse catalog data and merge same houses
        foreach ($arrReadFile as $keyArr => $valArr) {
            foreach ($fakeArray as $keyFakeArr => $valFakeArr) {
                if ($valFakeArr[1] == $valArr[1]) {
                    foreach ($valFakeArr as $keyFakeField => $valFakeField) {
                        $finalArray[$valArr[1]][$keyFakeField][$valFakeField] = $valFakeField;
                    }
                }
            }
        }

        // merger two arrays in final array
        foreach ($finalArray as $keyData => $valData) {
            foreach ($nameField as $keyNameField => $valNameField) {
                $resultArray[$keyData][$valNameField] = $finalArray[$keyData][$keyNameField];
            }
        }

        echo "<pre>"; print_r($resultArray); echo "</pre>";

    }


}
