<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{

    protected $table = "districts";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
