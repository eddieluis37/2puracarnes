<?php

namespace Database\Seeders;

use App\Models\Beneficiore;
use Illuminate\Database\Seeder;

class BeneficioreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Beneficiore::create([
            'thirds_id' => 2,
            'plantasacrificio_id' => 1,
            'cantidad' => 3,
            'fecha_beneficio' => now(),
            'factura' => 'PVM789',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'LT201',
            'status' => true,       
           
            'sacrificio' => 0,
            'fomento' => 0,
            'deguello' => 0,
            'bascula'  => 0,
            'transporte' => 0,
           
           
            'pesopie1'  => 121,
            'pesopie2'  => 122,
            'pesopie3'  => 123,

            'costoanimal1'  => 1100000,
            'costoanimal2'  => 1200000,
            'costoanimal3'  => 1300000,         
            
         
            'canalcaliente'  => 124000,  
            'canalfria'  => 124000,  
            'canalplanta'  => 124000,
            'pieleskg' => 24,
            'pielescosto'  => 578698,
            'visceras'  => 35687        

        ]); 

        
        Beneficiore::create([
            'thirds_id' => 1,
            'plantasacrificio_id' => 1,
            'cantidad' => 7,
            'fecha_beneficio' => now(),
            'factura' => 'PVM789',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'LT201',
            'status' => true,       
           
            'sacrificio' => 131000,
            'fomento' => 250000,
            'deguello' => 270000,
            'bascula'  => 124000,
            'transporte' => 90000,
           
           
            'pesopie1'  => 121,
            'pesopie2'  => 122,
            'pesopie3'  => 123,

            'costoanimal1'  => 1100000,
            'costoanimal2'  => 1200000,
            'costoanimal3'  => 1300000,         
            
         
            'canalcaliente'  => 124000,  
            'canalfria'  => 124000,  
            'canalplanta'  => 124000,
            'pieleskg' => 24,
            'pielescosto'  => 578698,
            'visceras'  => 35687  

        

        ]); 
    }
}
