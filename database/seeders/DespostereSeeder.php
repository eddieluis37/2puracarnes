<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Despostere;

class DespostereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Despostere::create([
            'users_id' => 1,
            'beneficiores_id' => 1,
            'products_id' => 1,
            'porcdesposte' => 33,
            'costo' => 12,
            'costo_kilo' => 6,
            'total' => 17,
            'precio' => '9875',          
            'total' => 17,
            'porcventa' => 3,                       
            'porcutilidad' => '17',  
            'status' => 'VALID'

        ]); 

    }
}
