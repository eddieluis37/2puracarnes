<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Levels_products;

class Levels_productSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Levels_products::create([			
			'name' => 'PADRE',
            'description' => 'ES EL CORTE COMPLETO',
			'status' => true
		]);
        Levels_products::create([			
			'name' => 'HIJO',
            'description' => 'ES EL SUB PRODUCTO',
			'status' => true
		]);
    }
}
