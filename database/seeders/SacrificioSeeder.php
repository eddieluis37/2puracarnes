<?php

namespace Database\Seeders;

use App\Models\Sacrificio;
use Illuminate\Database\Seeder;

class SacrificioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Sacrificio::create([
            'name' => 'FRIGORIFICO GUADALUPE SAS',
            'dni' => 98145892,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'transporte' => 11000,
            'sacrificio' => 131000,
            'fomento' => 25000,
            'deguello' => 27000,
            'bascula' => 12400,
        ]);

         Sacrificio::create([
            'name' => 'FRIGORIFICO GUADALUPE PLANTA DE CERDO',
            'dni' => 78145893,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'transporte' => 3500,
            'sacrificio' => 50333,
            'fomento' => 10667,
            'deguello' => 0,
            'bascula' => 12400,
        ]);

          
    }


}
