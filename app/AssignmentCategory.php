<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssignmentCategory extends Model
{

    protected $table = "assignment_categories";

    public $timestamps = false;

    public $fillable = [
    	"name",
    	"code",
    	"description",
    ];

}
