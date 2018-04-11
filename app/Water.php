<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Water extends Model
{

    protected $table = "waters";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
