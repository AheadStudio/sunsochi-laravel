<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relief extends Model
{

    protected $table = "reliefs";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
