<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deadline extends Model
{

    protected $table = "deadlines";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
