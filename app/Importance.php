<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Importance extends Model
{

    protected $table = "importances";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
