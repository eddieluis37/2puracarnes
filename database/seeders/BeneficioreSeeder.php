<?php

namespace Database\Seeders;

use App\Models\Beneficiore;
use Illuminate\Database\Seeder;
use DateTime;

class BeneficioreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = now();
		$current_date = new DateTime($now);
		$current_date->modify('next monday'); // Move to the next Monday
		$dateNextMonday = $current_date->format('Y-m-d'); // Output the date in Y-m-d format
        Beneficiore::create([
            'thirds_id' => 674,
            'plantasacrificio_id' => 1,
            'cantidadmacho' => 13,
            'valorunitariomacho' => 360000,
            'valortotalmacho' => 4680000,
            'cantidadhembra' => 17,
            'valorunitariohembra' => 350000,
            'valortotalhembra' => 5950000,
            'cantidad' => 30,
            'fecha_beneficio' => $now,
            'fecha_cierre' => $dateNextMonday,
            'factura' => 'PVM789',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'PC029',
            'finca' => 'finca 1',
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
            'cantidadmacho' => 13,
            'valorunitariomacho' => 360000,
            'valortotalmacho' => 4680000,
            'cantidadhembra' => 17,
            'valorunitariohembra' => 350000,
            'valortotalhembra' => 5950000,
            'cantidad' => 30,
            'fecha_beneficio' => $now,
            'fecha_cierre' => $dateNextMonday,
            'factura' => 'PVM789',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'LT201',
            'finca' => 'finca 2',
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
            'cantidadmacho' => 13,
            'valorunitariomacho' => 360000,
            'valortotalmacho' => 4680000,
            'cantidadhembra' => 17,
            'valorunitariohembra' => 350000,
            'valortotalhembra' => 5950000,
            'cantidad' => 30,
            'fecha_beneficio' => $now,
            'fecha_cierre' => $dateNextMonday,
            'factura' => 'FEV0991',
            'clientpieles_id' => 3,
            'clientvisceras_id' => 3,

            'lote' => 'LT201',
            'finca' => 'finca 3',
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
            'cantidadmacho' => 13,
            'valorunitariomacho' => 360000,
            'valortotalmacho' => 4680000,
            'cantidadhembra' => 17,
            'valorunitariohembra' => 350000,
            'valortotalhembra' => 5950000,
            'cantidad' => 30,
            'fecha_beneficio' => $now,
            'fecha_cierre' => $dateNextMonday,
            'factura' => 'FEV001',
            'clientpieles_id' => 236,
            'clientvisceras_id' => 798,

            'lote' => 'PC030',
            'finca' => 'PC030',
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
