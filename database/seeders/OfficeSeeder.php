<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;


class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Office::create([
            'name' =>'BOSA',
       ]);
        Office::create([
            'name' =>'GUADALUPE',
       ]);
        Office::create([
            'name' =>'LA NACIONAL',
       ]);
        Office::create([
            'name' =>'MINUTO DE DIOS',
       ]);
    }
}
