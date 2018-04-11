<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Heating extends Model
{

    protected $table = "heatings";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
