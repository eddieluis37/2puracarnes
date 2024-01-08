<?php

namespace Database\Seeders;

use App\Models\Notacredito;
use Illuminate\Database\Seeder;

class NotacreditoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notacredito::create([
            'sale_id' => 1,
            'status' => "2",
            'tipo' => "DEVOLUCION",
            'fecha_notacredito' => now(),
        ]);
    }
}
