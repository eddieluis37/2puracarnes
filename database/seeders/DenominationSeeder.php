<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denomination;

class DenominationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 2000
        ]);
         Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 5000
        ]);
          Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 10000
        ]);
           Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 20000
        ]);
            Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 50000
        ]);
             Denomination::create([
        	'type' => 'BILLETE',
        	'value' => 100000
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 100
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 200
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 500
        ]);
              Denomination::create([
        	'type' => 'MONEDA',
        	'value' => 1000
        ]);
              Denomination::create([
        	'type' => 'OTRO',
        	'value' => 0
        ]);
    }
}
