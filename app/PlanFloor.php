<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PlanFloor extends Model
{

    protected $table = "plan_floors";

    public $timestamps = false;

    public $fillable = [
    	"element_id",
    	"name",
    	"path",
    	"description",
    ];

}
