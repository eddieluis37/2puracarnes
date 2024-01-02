<?php

namespace Database\Seeders;

use App\Models\Saleformapago;
use Illuminate\Database\Seeder;


class SaleFormaPagosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Saleformapago::create([
            'codigo' => "EFECTIVO",
            'nombre' => "EFECTIVO",
            'tipoformapago' =>"MEDIOPAGO",
            'diascredito' => NULL,
            'cuenta' => 131564,
        ]);
        Saleformapago::create([
            'codigo' => "WOMPI",
            'nombre' => "WOMPI",
            'tipoformapago' =>"OTROS",
            'diascredito' => NULL,
            'cuenta' => 231564,
        ]);
        Saleformapago::create([
            'codigo' => "TRA",
            'nombre' => "WOMPI",
            'tipoformapago' =>"OTROS",
            'diascredito' => NULL,
            'cuenta' => 231564,
        ]);
      
    }
}
