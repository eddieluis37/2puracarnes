<?php

namespace Database\Seeders;
use App\Models\Listaprecio;

use Illuminate\Database\Seeder;

class ListaprecioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $lp = new Listaprecio([
            "id"=> "1", 
            "centrocosto_id" => "1", 
            "nombre" => "HOGAR", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "2", 
            "centrocosto_id" => "1", 
            "nombre" => "RESTAURANTE", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "3", 
            "centrocosto_id" => "1", 
            "nombre" => "FAMA", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "4", 
            "centrocosto_id" => "1", 
            "nombre" => "INSTITUCIONAL", 
            "tipo" => "NICHO"
        ]); $lp->save();
        $lp = new Listaprecio([
            "id"=> "5", 
            "centrocosto_id" => "1", 
            "nombre" => "GENERICA", 
            "tipo" => "GENERICA"
        ]); $lp->save();
    }
}
