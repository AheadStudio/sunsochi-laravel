<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AddOptions extends Model
{

    protected $table = "add_options";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
