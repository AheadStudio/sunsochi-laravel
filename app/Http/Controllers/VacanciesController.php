<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VacanciesController extends Controller
{
    // index page
    public function index() {
        return view("vacancies", [
            "pageTitle"     => "Вакансии",
            "pageSubtitle"  => "Нам всегда нужны ответственные работники в сфере недвижимости.",
        ]);
    }
}
