<?php

namespace Database\Seeders;

use App\Models\caja\Caja;
use Illuminate\Database\Seeder;


class CajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Caja::create([
            'user_id' => 1,
            'cajero_id' => 1,
            'centrocosto_id' => 1,
            'base' => 300000,           
            'valor_real' => 19145893,          
            
        ]);
    }
}
