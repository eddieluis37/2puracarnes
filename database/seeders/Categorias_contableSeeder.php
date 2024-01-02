<?php

namespace Database\Seeders;

use App\Models\Categorias_contable;
use Illuminate\Database\Seeder;


class Categorias_contableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categorias_contable::create([
            'name' => 'Activos fijos',
        ]);
        Categorias_contable::create([
            'name' => 'Caja - Bancos',
        ]);
        Categorias_contable::create([
            'name' => 'Costo de ventas',
        ]);
        Categorias_contable::create([
            'name' => 'Cuentas por cobrar',
        ]);
        Categorias_contable::create([
            'name' => 'Cuentas por pagar',
        ]);
        Categorias_contable::create([
            'name' => 'Gasto - Nómina',
        ]);
        Categorias_contable::create([
            'name' => 'Gastos',
        ]);
        Categorias_contable::create([
            'name' => 'Ingresos',
        ]);
        Categorias_contable::create([
            'name' => 'Inventarios',
        ]);
        Categorias_contable::create([
            'name' => 'Orden',
        ]);
        Categorias_contable::create([
            'name' => 'Otros activos',
        ]);
        Categorias_contable::create([
            'name' => 'Otros activos corrientes',
        ]);
        Categorias_contable::create([
            'name' => 'Otros gastos',
        ]);
        Categorias_contable::create([
            'name' => 'Otros ingresos',
        ]);
        Categorias_contable::create([
            'name' => 'Otros pasivos',
        ]);
        Categorias_contable::create([
            'name' => 'Otros pasivos corrientes',
        ]);
        Categorias_contable::create([
            'name' => 'Patrimonio',
        ]);
    }
}
