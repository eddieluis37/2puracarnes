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
            'codigo' => '11050501',
            'nombre' => 'Caja Principal',
            'categorias_contable_id' => 1,
            'clases_contable_id' => 1,
            'relaciones_contable_id' => 1, 
            'vencimientos' => 'No maneja',          
        ]);
        Parametrocontable::create([
            'codigo' => '11050502',
            'nombre' => 'Caja Punto de venta',
            'categorias_contable_id' => 2,
            'clases_contable_id' => 2,
            'relaciones_contable_id' => 2,
            'vencimientos' => 'En cartera',   
        ]);
    }
}
