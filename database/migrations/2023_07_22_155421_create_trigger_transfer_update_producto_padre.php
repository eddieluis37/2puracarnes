<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerTransferUpdateProductoPadre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER trigger_transfer_update_producto_padre AFTER INSERT ON updating_transfer FOR EACH ROW
            BEGIN                          
                UPDATE centro_costo_products
                SET stock = NEW.nuevo_stock
                WHERE products_id = NEW.productopadre_id AND centrocosto_id = NEW.centrocostoOrigen_id;
            END
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS trigger_transfer_update_producto_padre');
    }
}
