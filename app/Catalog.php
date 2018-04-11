<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Catalog extends Model
{
	protected $table = "catalogs";

	public $timestamps = false;

	protected $fillable = [
		"basic_section",
		"active",
		"name",
		"code",
		"preview_text",
		"preview_picture",
		"detail_text",
		"area",
		"price",
		"old_price",
		"price_m",
		"floors",
		"floor",
		"height_ceiling",
		"garage",
		"to_sea",
		"see_sea",
		"see_mountains",
		"number_bathrooms",
		"installment",
		"amount_commission",
		"secondary",
		"reason_rejection",
		"verification_date",
		"contacts_seller",
		"yandex_coord",
		"seo_title",
		"text_action",
		"street",
		"status_sale",
		"price_to",
		"price_from",
		"number_houses",
		"number_apartments",
		"cost_service",
		"place_from",
		"place_to",
		"gaz",
		"mortgage",
		"federal_law_214",
		"federal_law_215",
		"m_capital",
		"area_ap_min",
		"area_ap_max",
		"infrastructure",
		"for_dacha",
		"for_build",
		"price_hundred",
		"problem_obj",
		"home_show",
		"home_readiness",
		"type_building",
		"developer_buildings",
		"apartments_sea_view",
		"apartments_mount_view",
		"status_real_estates",
		"video",
		"include",
		"military_mortgage",
		"profit",
		"size_remuneration",
		"cottage_village",
		"gsk",
	];

	static function getList() {
		return DB::table('blogs')->get();
	}
}
