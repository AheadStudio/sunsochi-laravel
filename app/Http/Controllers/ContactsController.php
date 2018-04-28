<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\GoodCode\Helper;

class ContactsController extends Controller
{
    // index page
    public function index() {

        // SEO information
        Helper::setSEO(
            "Наши контакты",
            "Компания “Солнечный Сочи” занимается экспертным подбором недвижимости любых типов в городе-курорте Сочи, организовывая не только полное сопровождение сделки, но и предлагая инвестиционные проекты “под ключ”.",
            "http://sunsochi.goodcode.ru"
        );

        return view("contacts", [
            "pageTitle" => "Контакты",
            "mapPoint" => "43.604412115253794,39.73532647212506"
        ]);
    }
}
