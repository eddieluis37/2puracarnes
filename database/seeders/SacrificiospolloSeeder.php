<?php

namespace Database\Seeders;

use App\Models\Sacrificiopollo;
use Illuminate\Database\Seeder;

class SacrificiospolloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sacrificiopollo::create([
            'name' => 'PLANTA DE POLLO ANDINO',
            'dni' => 78145897,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'transporte' => 0,
            'sacrificio' => 1000,
            'fomento' => 0,
            'deguello' => 0,
            'bascula' => 0,
        ]);

          Sacrificiopollo::create([
            'name' => 'PLANTA FAMICOL',
            'dni' => 78145894,
            'address' => 'CALLE 124B #17A-37SUR BOGOTA',
            'phone' => 3132623896,
            'email' => 'Frigorificoguada@gmail.com',
            'transporte' => 0,
            'sacrificio' => 1080,
            'fomento' => 0,
            'deguello' => 0,
            'bascula' => 0,
        ]);
    }
}
