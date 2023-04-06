<?php

namespace Database\Seeders;

use App\Models\Type_identification;
use Illuminate\Database\Seeder;


class Type_identificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         Type_identification::create([
            'name' => 'NIT'
        ]);
        Type_identification::create([
            'name' => 'Cédula de ciudadanía'
        ]);
        Type_identification::create([
            'name' => 'Permiso especial de permanencia PEP'
        ]);
        Type_identification::create([
            'name' => 'Sin identificación del exterior o para uso definido por la DIAN'
        ]);
    }
}
