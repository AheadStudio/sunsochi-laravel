<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeBuilding extends Model
{

    protected $table = "type_buildings";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
