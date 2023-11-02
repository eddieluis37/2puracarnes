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
            "nombre" => "GENERAL - GUADALUPE", 
            "tipo" => "GENERAL"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "2", 
            "centrocosto_id" => "1", 
            "nombre" => "HOGAR - GUADALUPE", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "3", 
            "centrocosto_id" => "1", 
            "nombre" => "PUNTO DE VENTA - GUADALUPE", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "4", 
            "centrocosto_id" => "1", 
            "nombre" => "INSTITUCIONAL/FAMA - GUADALUPE", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "5", 
            "centrocosto_id" => "1", 
            "nombre" => "REST PROD PORCIONADO - GUADALUPE", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "6", 
            "centrocosto_id" => "1", 
            "nombre" => "REST PROD EN POSTA - GUADALUPE", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "7", 
            "centrocosto_id" => "1", 
            "nombre" => "APP MOVIL PLAYSTORE/APPLE - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "8", 
            "centrocosto_id" => "1", 
            "nombre" => "RAPPI - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "9", 
            "centrocosto_id" => "1", 
            "nombre" => "COLEGIO MINUTO DE DIOS - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "10", 
            "centrocosto_id" => "1", 
            "nombre" => "RAMDY - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "11", 
            "centrocosto_id" => "1", 
            "nombre" => "MEGATIENDAS - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "12", 
            "centrocosto_id" => "1", 
            "nombre" => "JOSE SIERRA ESSASY - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "13", 
            "centrocosto_id" => "1", 
            "nombre" => "GRUPO NAZCA - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "14", 
            "centrocosto_id" => "1", 
            "nombre" => "CASINO FAC - GUADALUPE",
            "tipo" => "NICHO"
        ]); $lp->save();


    // PARA SEGUNDO CENTRO COSTO

        $lp = new Listaprecio([
            "id"=> "15", 
            "centrocosto_id" => "2", 
            "nombre" => "GENERAL - MIN DE DIOS", 
            "tipo" => "GENERAL"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "16", 
            "centrocosto_id" => "2", 
            "nombre" => "HOGAR - MIN DE DIOS", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "17", 
            "centrocosto_id" => "2", 
            "nombre" => "PUNTO DE VENTA - MIN DE DIOS", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "18", 
            "centrocosto_id" => "2", 
            "nombre" => "INSTITUCIONAL/FAMA - MIN DE DIOS", 
            "tipo" => "NICHO"
        ]); $lp->save();
        
        $lp = new Listaprecio([
            "id"=> "19", 
            "centrocosto_id" => "2", 
            "nombre" => "REST PROD PORCIONADO - MIN DE DIOS", 
            "tipo" => "NICHO"
        ]); $lp->save();

        $lp = new Listaprecio([
            "id"=> "20", 
            "centrocosto_id" => "2", 
            "nombre" => "REST PROD EN POSTA - MIN DE DIOS", 
            "tipo" => "NICHO"
        ]); $lp->save();       
       
    }
}
