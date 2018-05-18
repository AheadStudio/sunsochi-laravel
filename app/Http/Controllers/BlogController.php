<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Response;
use Illuminate\Http\Request;

use App\GoodCode\ParseCsv;
use App\GoodCode\Helper;

use App\Blog;

use Session;
use Excel;
use File;

class BlogController extends Controller
{
    // index page
    public function index() {

        // SEO information
        Helper::setSEO("Блог", "Блог компании “Солнечный Сочи”", "http://sunsochi.goodcode.ru");

        // main query
        $blogsQuery = Blog::orderBy("views", "desc")
                          ->orderBy("date", "asc");

        // main query
        $blogsQueryPopular = Blog::orderBy("views", "desc")
                                ->orderBy("date", "asc");

        // get popular blog item and add cache
        /*$blogsPopular = Cache::remember("blogsPopularNew", 24*60, function() use(&$blogsQueryPopular) {
            return $blogsQueryPopular->where("popular", 1)->get();
        });*/

        // get max views blog item and add cache
        /*$blogMaxViews = Cache::remember("blogsMaxViewNew", 24*60, function() use(&$blogsQuery) {
            return $blogsQuery->first();
        });*/
        $blogsPopular = $blogsQueryPopular->where("popular", 1)->get();
        $blogMaxViews = $blogsQueryPopular->first();
        $blogsList = $blogsQuery->paginate(4);

        // get all glog item and add cashe
        /*$blogsList = Cache::remember("blogsListNew", 24*60, function() use(&$blogsQuery) {
            return $blogsQuery->paginate(4);
        });*/

        foreach ($blogsList as $key => $val) {
            $blogsList[$key]->date = Helper::convertDate($val->date);
        }

        $blogMaxViews->date = Helper::convertDate($blogMaxViews->date);

        /* for vue pagination
        $pagination = [
            'total' => $blogsList->total(),
            'current_page' => $blogsList->currentPage(),
            'last_page' => $blogsList->lastPage(),
        ];*/

        return view("blog-list", [
            "blogList"      => $blogsList,
            //"blogPagination"=> json_encode($pagination),
            "blogPopular"   => $blogsPopular,
            "blogMaxViews"  => $blogMaxViews,
            "pageTitle"     => "Блог",
        ]);
    }

    // detail page
    public function show($code) {
        $blogItem = Blog::where("code", $code)->first();

        if (!isset($blogItem)) {
            return redirect(404);
        }

        $blogItemSimularId = $blogItem->similar()
                                        ->get()
                                        ->pluck("element_id");

        $blogItemSimular = Blog::whereIn("id", $blogItemSimularId)
                                ->orderBy("views", "desc")
                                ->get();

        // SEO information
        Helper::setSEO($blogItem->name, "Блог компании “Солнечный Сочи”", "http://sunsochi.goodcode.ru");

        $blogItem->date = Helper::convertDate($blogItem->date);

        // views + 1
        $countViews = Blog::where("code", $code)->increment("views", 1);

        return view("blog-detail", [
            "blogItem"          => $blogItem,
            "blogItemSimilar"   => $blogItemSimular,
            "pageTitle"         => $blogItem->name
        ]);

    }

    // import
    public function import() {
        return view("import", ["action" => route("BlogImportSend")]);
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

}
