<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactsController extends Controller
{
    // index page
    public function index() {
        return view("contacts", [
            "pageTitle" => "Контакты",
            "mapPoint" => "43.604412115253794,39.73532647212506"
        ]);
    }
}
