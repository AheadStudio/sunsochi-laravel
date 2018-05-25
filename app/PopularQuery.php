<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopularQuery extends Model
{
    protected $table = "popular_query";

    public $fillable = [
        "id",
        "name",
        "url",
        "popular",
        "count_elements",
    ];
}
