<?php

namespace Database\Seeders;

use App\Models\Nicho_mercado;
use Illuminate\Database\Seeder;

class Nicho_mercadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nicho_mercado::create([
            'name' =>'FAMA',
            'status' => true
       ]);
       Nicho_mercado::create([
            'name' =>'INSTITUCIONAL',
            'status' => true
       ]);
       Nicho_mercado::create([
            'name' =>'HORECA',
       ]);
       Nicho_mercado::create([
            'name' =>'HOGAR',
            'status' => true
       ]);
    }
}
