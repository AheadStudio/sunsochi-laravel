<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClassBuildings extends Model
{

    protected $table = "class_buildings";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
