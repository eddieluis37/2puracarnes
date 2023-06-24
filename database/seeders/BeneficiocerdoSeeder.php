<?php

namespace Database\Seeders;

use App\Models\Beneficiocerdo;
use Illuminate\Database\Seeder;
use DateTime;

class BeneficiocerdoSeeder extends Seeder
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
        Beneficiocerdo::create([
            'thirds_id' => 674,
            'plantasacrificiocerdo_id' => 1,      
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
        
      
    }
   
}
