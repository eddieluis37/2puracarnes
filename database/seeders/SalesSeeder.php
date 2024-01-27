<?php

namespace Database\Seeders;

use App\Models\Sale;
use Illuminate\Database\Seeder;

class SalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sale::create([
            'user_id' => 1,
            'third_id' => 30,
            'vendedor_id' => 1,
            'domiciliario_id' => NULL,
            'centrocosto_id' => 1,
            'items' => 3,
            'total_bruto' => 3000,
            'descuentos' => 0,
            'forma_pago_otros_id' => 1,
            'valor_pagado' => 95000,
            'fecha_venta' => now(),            
            'consecutivo' => "GUA0001",
            'resolucion' => "PRU 00001",
        ]);

        Sale::create([
            'user_id' => 2,
            'third_id' => 2,
            'vendedor_id' => 2,
            'domiciliario_id' => NULL,
            'centrocosto_id' => 2,
            'items' => 3,
            'total_bruto' => 3000,
            'descuentos' => 0,
            'forma_pago_otros_id' => 2,
            'valor_pagado' => 95000,
            'fecha_venta' => now(),            
            'consecutivo' => "GUA0002",
            'resolucion' => "PRU 00002",
        ]);
    }
}
