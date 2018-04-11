<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ForInvestment extends Model
{

    protected $table = "for_investments";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
