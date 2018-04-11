<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Picture extends Model
{

    protected $table = "pictures";

    public $timestamps = false;

    public $fillable = [
    	"element_id",
    	"name",
    	"path",
    	"description",
    ];

}
