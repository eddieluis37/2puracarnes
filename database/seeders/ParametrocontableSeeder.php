<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Parametrocontable;
class ParametrocontableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Parametrocontable::create([
            'codigo' =>'IVA',
            'nombre' =>'IMPTO IVA',
            'tipoparametro' =>'COMPRA',
            'cuenta' =>'150101',        
       ]);
       Parametrocontable::create([
        'codigo' =>'DESCUENTO',
        'nombre' =>'DESCUENTO POR COMPRA',
        'tipoparametro' =>'COMPRA',
        'cuenta' =>'110101',         
        ]);
    }
}

