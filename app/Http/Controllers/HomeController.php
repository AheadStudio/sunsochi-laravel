<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Http\Controllers\ApiController;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Request;

use App\GoodCode\Helper;

// table derictory
use App\Catalog;
use App\CatalogsSection;
use App\CatalogsElement;
use App\ElementDirectory;
use App\District;
use App\Predestination;
use App\Review;

class HomeController extends Controller {

    function show() {
        // set SEO for page
        Helper::setSEO(
            "Главная страница",
            "Каталог компании “Солнечный Сочи”",
            URL::current()
        );

        // get district
        $district = District::select("id", "code", "name", "popular")
                                          ->get();

        // get predestination
        $predestination = Cache::remember("catalogPredestination", 60, function() {
            return Predestination::select("id", "code", "name")->get();
        });

        // get profit offers
        $profitOffers = Catalog::where("profit_offers", 1)
                               ->get()
                               ->take(12);

        $profitOffers = Helper::getGsk($profitOffers)->chunk(6);

        // get big card
        $bigCard = Catalog::select("*", "catalogs.id", "catalogs.name", "catalogs.code", "builders.name as builders_name")
                          ->where("big_card", 1)
                          ->join("builders", "catalogs.developer_buildings", "=", "builders.id")
                          ->get();

        $bigCard = Helper::getGsk($bigCard)->toArray();

        // get reviews
        $reviewList = Review::orderBy("date", "asc")
                            ->get()
                            ->take(5);

        foreach ($reviewList as $keyList => $valList) {
            $finalText = Helper::splitText($valList->text, 50);
            $valList->textOther = $finalText[0];
            $valList->text = $finalText[1];
        }

        $pageParams = [
            "district"          => $district,
            "predestination"    => $predestination ,
            "profitOffers"      => [$profitOffers[0], $profitOffers[1]],
            "countProfitOffers" => count($profitOffers->toArray()),
            "showFind"          => false,
            "bigCard"           => $bigCard[0],
            "reviewList"        => $reviewList->toArray(),
        ];

	    return view("home", $pageParams);

    }

}
