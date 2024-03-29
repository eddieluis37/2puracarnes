<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\centros\Centrocosto;



class CentrocostoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Centrocosto::create([
        'name' => 'GUADALUPE',
        'prefijo' => 'GUA',
        ]);
        Centrocosto::create([
        'name' => 'MINUTO DE DIOS',
        'prefijo' => 'MIN',
        ]);       
    }
}
