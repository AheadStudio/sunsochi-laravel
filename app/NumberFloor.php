<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberFloor extends Model
{

    protected $table = "number_floors";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
