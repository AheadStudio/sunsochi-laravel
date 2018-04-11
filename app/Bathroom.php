<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bathroom extends Model
{

    protected $table = "bathrooms";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
