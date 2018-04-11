<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberRoom extends Model
{

    protected $table = "number_rooms";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
