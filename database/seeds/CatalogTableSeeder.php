<?php

use Illuminate\Database\Seeder;

class CatalogTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
	    for($i = 0; $i < 100; $i++) {
	        DB::table('catalog')->insert([
	            'name' => str_random(10),
	            'code' => str_random(10),
	            'description' => str_random(500),
	        ]); 
	    }

    }
}
