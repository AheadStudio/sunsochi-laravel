<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CatalogsSection extends Model
{

    protected $table = "catalogs_sections";

    public $timestamps = false;

    public $fillable = [
    	"active",
    	"parent_id",
    	"name",
    	"code",
    	"picture",
    ];

}
