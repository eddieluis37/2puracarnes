<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Products\Unitofmeasure;

class UnitofmeasureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Unitofmeasure::create([
        	'name' => 'KILOGRAMO NETO',
        	'description' => '',
        	'status' => true
        ]);
        Unitofmeasure::create([
        	'name' => 'UNIDAD',
        	'description' => '',
        	'status' => true
        ]);
    }
}
