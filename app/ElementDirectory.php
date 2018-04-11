<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ElementDirectory extends Model
{

    protected $table = "element_directories";

    public $timestamps = false;

    protected $fillable = [
        "name_table",
        "name_field",
        "element_id",
        "code",
    ];

}
