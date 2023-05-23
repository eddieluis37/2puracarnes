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
        ]);
        Centrocosto::create([
        'name' => 'MINUTO DE DIOS',
        ]);
        Centrocosto::create([
        'name' => 'NACIONAL',
        ]);
        Centrocosto::create([
        'name' => 'SAN JOSE',
        ]);
    }
}
