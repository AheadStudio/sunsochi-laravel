<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatalogsElement extends Model
{

    protected $table = "catalogs_elements";

    public $timestamps = false;

    protected $fillable = [
        "parent_id",
        "element_id",
    ];

}
