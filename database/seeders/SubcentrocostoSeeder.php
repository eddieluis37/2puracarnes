<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcentrocosto;

class SubcentrocostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "HOGAR",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "PUNTO DE VENTA GUAD",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "HORECA",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "ADMINISTRATIVO",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "INSTITUCIONALES / FAMA",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "INSTITUCIONALES / LICITAC",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "ON LINE / RESTAU PORCIONADO",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "ON LINE / RESTAU POSTA",
        ]);
        Subcentrocosto::create([
            'centrocosto_id' => 1,
            'name' => "PIELES / VISCERAS",
        ]);
    }
}
