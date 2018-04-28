<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GoodCode\Helper;

class AboutController extends Controller
{
    // index page
    public function index() {

        // SEO information
        Helper::setSEO(
            "О компании",
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            "http://sunsochi.goodcode.ru"
        );

        return view("about", [
            "pageTitle" => "О компании"
        ]);
    }

}
