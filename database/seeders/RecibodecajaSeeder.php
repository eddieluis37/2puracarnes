<?php

namespace Database\Seeders;

use App\Models\Recibodecaja;
use Illuminate\Database\Seeder;


class RecibodecajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $recibodecaja = new Recibodecaja(["user_id" => "1", "third_id" => "30", "sale_id" => "1", "tipo" => "1", "formapagos_id" => "1", "valor_recibido" => "0", "fecha_elaboracion" => "2024-01-29", "fecha_cierre" => "2024-01-29", "consecutivo" => "A", "consec" => "0", "status" => "0", "tipo" => "0", "realizar_un" => "Abono a deuda"]);
        $recibodecaja->save();
    }
}
