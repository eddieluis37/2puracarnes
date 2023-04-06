<?php

namespace Database\Seeders;

use App\Models\Precio;
use Illuminate\Database\Seeder;

class PrecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Precio::create([
        	'valor1' => 10000
        	
        ]);       
        Precio::create([
        	'valor1' => 11000
        
        ]);
        Precio::create([
          'valor1' => 12000
           
        ]);
        Precio::create([
            'valor1' => 13000
            
        ]);
        Precio::create([
           'valor1' => 14000         
        ]);
         Precio::create([
        	'valor1' => 15000
        	
        ]);
        Precio::create([
        	'valor1' => 16000
        	
        ]);
    }
}
