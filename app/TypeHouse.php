<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeHouse extends Model
{

    protected $table = "type_houses";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
