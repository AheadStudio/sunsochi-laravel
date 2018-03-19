<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Catalog extends Model
{
	static function getList() {
		return DB::table('blogs')->get();
	}
}
