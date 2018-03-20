<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function getBlog() {
        $news = DB::table("news")->get();
        return view("news", ['news' => $news]);
    }
}
