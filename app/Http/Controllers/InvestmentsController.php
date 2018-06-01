<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;

use App\GoodCode\Helper;

use App\Catalog;
use App\CatalogsSection;
use App\District;

class InvestmentsController extends Controller
{
    // index page
    public function index() {

        $pageParams["pageTitle"] = "Инвестиции в недвижимость Сочи с прибылью от 20% годовых";
        $pageParams["pageTabs"] = ["Доход выше накопительных вкладов", "Долгосрочные и краткосрочные вложения денег", "Безопаснее банковских вкладов"];
        $pageParams["pageImage"] = "/dummy/investments.jpg";

        Helper::setSEO(
            $pageParams["pageTitle"],
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            URL::current()
        );

        return view("investments/index", $pageParams);

    }

    public function section($section) {
        switch ($section) {
            case "resale":
                $pageParams["pageTitle"] = "Перепродажа различных объектов";
                $pageParams["pageTabs"] = ["Быстрое получение прибыли", "Разработка проекта 'под ключ'", "Возможность дистанционной покупки"];
                $pageParams["pageImage"] = "/dummy/investments_build.jpg";
                break;
            case "lease":
                $pageParams["pageTitle"] = "Инвестирование в покупку квартиры для последующей сдачи в аренду";
                $pageParams["pageTabs"] = ["Быстрое получение прибыли", "Разработка проекта 'под ключ'", "Возможность дистанционной покупки"];
                $pageParams["pageImage"] = "/dummy/investments_2.jpg";
                break;
            case "building":
                $pageParams["pageTitle"] = "Инвестирование в строительство на участках";
                $pageParams["pageTabs"] = ["Быстрое получение прибыли", "Разработка проекта 'под ключ'", "Возможность дистанционной покупки"];
                $pageParams["pageImage"] = "/dummy/investments_1.jpg";
                break;
        }
        $pageParams["pageCode"] = $section;


        // get district
        $pageParams["district"] = District::select("id", "code", "name", "popular")
                                          ->get();

        $elements = Catalog::select("*", "catalogs.id", "catalogs.code")
                           ->whereNotNull("catalogs.code")
                           ->join("element_directories as el_code_investments", function ($join) use (&$section) {
                               $join->on("catalogs.id", "=", "el_code_investments.element_id");
                                   if ($section == "resale") {
                                       $join->where("el_code_investments.code", "=", "Tx2477Dx");
                                   }
                                   if ($section == "lease") {
                                       $join->where("el_code_investments.code", "=", "c5ILKt8a");
                                   }
                                   if ($section == "building") {
                                       $join->where("el_code_investments.code", "=", "Hdhotk6j");
                                   }
                           })
                           ->paginate(9);

        $elements = Helper::getGsk($elements);

        $pageParams["offers"]       = $elements;
        $pageParams["countOffers"]  = $elements->total();
        $pageParams["showFind"]     = true;

        Helper::setSEO(
            $pageParams["pageTitle"],
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            URL::current()
        );

        return view("investments/section", $pageParams);
    }

    public function getFilterCount(Request $request) {
        //set parameters for request
        $request = [
            "url"           => $request->url(),
            "params"        => $request->params,
            "main_section"  => $request->main_section,
            "only_count"    => $request->only_count,
        ];

        $elements = ApiController::getCatalog($request);

        return view("catalog/sections-filter-button", ["countElements" => $elements]);

    }

    public function getFilterItems(Request $request) {
        //set parameters for request
        $request = [
            "url"           => $request->url(),
            "params"        => $request->params,
            "main_section"  => $request->main_section,
            "only_count"    => $request->only_count,
        ];

        $elements = ApiController::getCatalog($request);

        $pageParams["offers"]       = $elements;
        $pageParams["countOffers"]  = $elements->total();
        $pageParams["showFind"]     = true;

        return view("investments/offers-items", $pageParams);
    }

}
