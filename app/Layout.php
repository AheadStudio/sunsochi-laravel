<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Layout extends Model
{

    protected $table = "layouts";

    public $timestamps = false;

    public $fillable = [
    	"element_id",
    	"name",
    	"path",
    	"description",
    ];

}
