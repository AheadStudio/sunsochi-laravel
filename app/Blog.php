<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    // relationship for get similar blog items
    public function similar() {
        return $this->hasMany("App\BlogsSimilar", "parent_id");
    }

}
