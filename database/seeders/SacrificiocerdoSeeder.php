<?php

namespace Database\Seeders;

use App\Models\Sacrificiocerdo;
use Illuminate\Database\Seeder;

class SacrificiocerdoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sacrificiocerdo::create([
            'name' => 'FRIGORIFICO GUADALUPE PLANTA CERDO',
            'dni' => 99145893,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'sacrificio' => 50333,
            'fomento' => 10667,           
            'deguello' => 0,
            'bascula' => 0,
            'transporte' => 3500
            
        ]);
    }
}
