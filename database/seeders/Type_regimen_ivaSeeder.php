<?php

namespace Database\Seeders;

use App\Models\Type_regimen_iva;
use Illuminate\Database\Seeder;

class Type_regimen_ivaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Type_regimen_iva::create([
            'name' => 'Responsable de IVA'
        ]);
        Type_regimen_iva::create([
            'name' => 'No responsable de IVA'
        ]);
         Type_regimen_iva::create([
            'name' => 'Regimen simple de tributaria'
        ]);
        Type_regimen_iva::create([
            'name' => 'Gran contribuyente'
        ]);
        Type_regimen_iva::create([
            'name' => 'Autorretenedor'
        ]);
    }
}
