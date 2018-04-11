<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sewerage extends Model
{

    protected $table = "sewerages";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
