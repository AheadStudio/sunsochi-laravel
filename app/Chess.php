<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Chess extends Model
{

    protected $table = "chess";

    public $timestamps = false;

    public $fillable = [
    	"element_id",
    	"old_obj",
    	"old_width",
    	"old_height",
    	"new_obj",
    	"section",
    	"section_list",
    	"section_name",
    	"section_lenght",
    ];

}
