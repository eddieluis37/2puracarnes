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
            'dni' => 98145892-2,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'sacrificio' => 131000,
            'fomento' => 29000,           
            'deguello' => 30000,
            'bascula' => 12400,
            'transporte' => 11300
        ]);

         Sacrificio::create([
            'name' => 'FRIGORIFICO GUADALUPE SAS # 1',
            'dni' => 98145892-1,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'sacrificio' => 131000,
            'fomento' => 0,           
            'deguello' => 30000,
            'bascula' => 0,
            'transporte' => 11300
        ]);

        Sacrificio::create([
            'name' => 'MIERCOLES EN FRIGORIFICO GUADALUPE SAS',
            'dni' => 98145892-3,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'sacrificio' => 107000,
            'fomento' => 29000,           
            'deguello' => 30000,
            'bascula' => 12400,
            'transporte' => 11300
        ]);

          
    }


}
