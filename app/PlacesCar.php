<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlacesCar extends Model
{

    protected $table = "places_cars";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
