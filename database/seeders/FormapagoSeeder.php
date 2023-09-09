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
            "codigo"=> "CONTADO", "nombre" => "COMPRA DE CONTADO", "tipoformapago" => "COMPRA", "cuenta" => "220501"
        ]); $formapago->save();
        
        $formapago = new Formapago([
            "codigo"=> "CREDITO", "nombre" => "CCOMPRA A CREDITO", "tipoformapago" => "COMPRA", "cuenta" => "220501"
        ]); $formapago->save();       
      
    }
}
