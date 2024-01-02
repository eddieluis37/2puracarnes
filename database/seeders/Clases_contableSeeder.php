<?php

namespace Database\Seeders;

use App\Models\Clases_contable;
use Illuminate\Database\Seeder;


class Clases_contableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Clases_contable::create([
            'name' => 'Activo',
        ]);
        Clases_contable::create([
            'name' => 'Pasivo',
        ]);
        Clases_contable::create([
            'name' => 'Patrimonio',
        ]);
        Clases_contable::create([
            'name' => 'Ingresos',
        ]);
        Clases_contable::create([
            'name' => 'Gastos',
        ]);
        Clases_contable::create([
            'name' => 'Costos de venta',
        ]);
        Clases_contable::create([
            'name' => 'Costos de producción o de operación',
        ]);
        Clases_contable::create([
            'name' => 'Cuentas de orden acreedoras',
        ]);
    }
}
