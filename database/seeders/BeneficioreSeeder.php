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
            'centrocosto_id' => 1,
            'thirds_id' => 1,
            'plantasacrificio_id' => 1,
            'cantidadmacho' => 15,
            'valorunitariomacho' => 350000,
            'valortotalmacho' => 5250000,
            'cantidadhembra' => 0,
            'valorunitariohembra' => 0,
            'valortotalhembra' => 0,
            'cantidad' => 15,
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

            'pesopie1'  => 7500,
            'pesopie2'  => 0,
            'pesopie3'  => 0,

            'costoanimal1'  => 9400,
            'costoanimal2'  => 0,
            'costoanimal3'  => 0,                     
         
            'canalcaliente'  => 4350,  
            'canalfria'  => 0,  
            'canalplanta'  => 4340,
            'pieleskg' => 600,
            'pielescosto'  => 1200,
            'visceras'  => 5250000      
        ]);
        
        Beneficiore::create([
            'centrocosto_id' => 2,
            'thirds_id' => 2,
            'plantasacrificio_id' => 1,
            'cantidadmacho' => 15,
            'valorunitariomacho' => 350000,
            'valortotalmacho' => 5250000,
            'cantidadhembra' => 0,
            'valorunitariohembra' => 0,
            'valortotalhembra' => 0,
            'cantidad' => 15,
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

            'pesopie1'  => 7500,
            'pesopie2'  => 0,
            'pesopie3'  => 0,

            'costoanimal1'  => 9400,
            'costoanimal2'  => 0,
            'costoanimal3'  => 0,                     
         
            'canalcaliente'  => 4350,  
            'canalfria'  => 0,  
            'canalplanta'  => 4340,
            'pieleskg' => 600,
            'pielescosto'  => 1200,
            'visceras'  => 5250000      
        ]);         
    }
}
