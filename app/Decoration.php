<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Decoration extends Model
{

    protected $table = "decorations";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
