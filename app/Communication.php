<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Communication extends Model
{

    protected $table = "communications";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
