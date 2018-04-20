<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutController extends Controller
{
    // index page
    public function index() {
        return view("about", [
            "pageTitle"     => "О компании"
        ]);
    }
}
