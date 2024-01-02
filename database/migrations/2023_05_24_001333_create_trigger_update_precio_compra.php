<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerUpdatePrecioCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
          /*   CREATE TRIGGER trigger_update_precio_compra AFTER INSERT ON compensadores_details FOR EACH ROW
            BEGIN
                UPDATE products
                SET cost = NEW.pcompra
                WHERE id = NEW.products_id;
            END */
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_update_precio_compra');
    }
}
