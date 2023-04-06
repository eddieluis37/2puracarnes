<?php

namespace Database\Seeders;

use App\Models\Precio_agreement;
use Illuminate\Database\Seeder;

class Precio_agreementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Precio_agreement::create([
          'line' => "HOGAR",
        	'agreement_id' => 1,
        	'precio' => 1000,
          'user_id' => 1,
        	'product_id' => 1,

        	
        ]);       
        Precio_agreement::create([
        	'line' => "HORECA",
          'agreement_id' => 2,
        	'precio' => 2000,
          'user_id' => 2,
        	'product_id' => 2,
        
        ]);
        Precio_agreement::create([
          'line' => "INSTITUCIONAL",
          'agreement_id' => 3,
          'precio' => 3000,
          'user_id' => 2,
          'product_id' => 3,
           
        ]);
        Precio_agreement::create([
            'line' => "FAMAS",
            'agreement_id' => 4,
            'precio' => 4000,
            'user_id' => 3,
            'product_id' => 4,
            
        ]);
        Precio_agreement::create([
           'line' => "INSTITUCIONAL",
           'agreement_id' => 5,
           'precio' => 5000,  
           'user_id' => 1,
           'product_id' => 5,       
        ]);
         
    }
}
