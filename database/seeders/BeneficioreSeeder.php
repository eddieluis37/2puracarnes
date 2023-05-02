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
            'thirds_id' => 674,
            'plantasacrificio_id' => 1,
            'cantidad' => 30,
            'fecha_beneficio' => now(),
            'factura' => 'PVM789',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'PC029',
            'status' => true,

            'sacrificio' => 131000,
            'fomento' => 29000,
            'deguello' => 30000,
            'bascula'  => 12400,
            'transporte' => 11300,

            'pesopie1'  => 7989,
            'pesopie2'  => 0,
            'pesopie3'  => 0,

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

        Beneficiore::create([
            'thirds_id' => 1,
            'plantasacrificio_id' => 1,
            'cantidad' => 7,
            'fecha_beneficio' => now(),
            'factura' => 'FEV0991',
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

        Beneficiore::create([
            'thirds_id' => 674,
            'plantasacrificio_id' => 1,
            'cantidad' => 30,
            'fecha_beneficio' => now(),
            'factura' => 'FEV001',
            'clientpieles_id' => 236,
            'clientvisceras_id' => 798,

            'lote' => 'PC030',
            'status' => true,       
           
            'sacrificio' => 131000,
            'fomento' => 250000,
            'deguello' => 270000,
            'bascula'  => 124000,
            'transporte' => 90000,
           
           
            'pesopie1'  => 0,
            'pesopie2'  => 0,
            'pesopie3'  => 0,

            'costoanimal1'  => 9450,
            'costoanimal2'  => 0,
            'costoanimal3'  => 0,         
            
         
            'canalcaliente'  => 4329,  
            'canalfria'  => 0,  
            'canalplanta'  => 0,
            'pieleskg' => 554,
            'pielescosto'  => 1700,
            'visceras'  => 3600, 
            
            'costopie1'  => 3600, 
        ]);
    }
}
