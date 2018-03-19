<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller {
    function home() {
	    //echo str_slug("Этосамая отличная статья на свете! Она на 5% безопаснее :)", "_");
	    return view("home");
    }
    function CompanyAbout() {
	    return view("home");
    }
    function default() {
	    
	    return view("home");
    }
}
