<?php

namespace Database\Seeders;

use App\Models\Formapago;
use Illuminate\Database\Seeder;

class FormapagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $formapago = new Formapago([
            "codigo"=> "EFECTIVO", "nombre" => "EFECTIVO ", "tipoformapago" => "COMPRA", "cuenta" => "11050501"
        ]); $formapago->save();
        
        $formapago = new Formapago([
            "codigo"=> "CREDITO", "nombre" => "CREDITO PROV NACIONALES", "tipoformapago" => "COMPRA", "cuenta" => "22050501"
        ]); $formapago->save();       
      
    }
}
