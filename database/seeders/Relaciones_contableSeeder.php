<?php

namespace Database\Seeders;

use App\Models\Relaciones_contable;
use Illuminate\Database\Seeder;


class Relaciones_contableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Relaciones_contable::create([
            'name' => 'Activo',
        ]);
        Relaciones_contable::create([
            'name' => 'Pasivo',
        ]);
        Relaciones_contable::create([
            'name' => 'Patrimonio',
        ]);
        Relaciones_contable::create([
            'name' => 'Ingresos',
        ]);
        Relaciones_contable::create([
            'name' => 'Gastos',
        ]);
        Relaciones_contable::create([
            'name' => 'Costos de venta',
        ]);
        Relaciones_contable::create([
            'name' => 'Costos de producción o de operación',
        ]);
        Relaciones_contable::create([
            'name' => 'Cuentas de orden acreedoras',
        ]);
    }
}
