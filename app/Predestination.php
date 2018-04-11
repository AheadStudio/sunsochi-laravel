<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Predestination extends Model
{

    protected $table = "predestination";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
