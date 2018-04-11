<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StatusSales extends Model
{

    protected $table = "status_sales";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
