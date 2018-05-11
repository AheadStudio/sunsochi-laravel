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

    public function getCatalogElements() {
        return $this->belongsToMany("App\Catalog", "catalogs_elements", "parent_id", "element_id");
    }

}
