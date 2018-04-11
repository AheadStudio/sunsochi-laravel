<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurposePurchases extends Model
{

    protected $table = "purpose_purchases";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
