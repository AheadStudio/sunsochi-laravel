<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingPlaces extends Model
{

    protected $table = "parking_places";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
