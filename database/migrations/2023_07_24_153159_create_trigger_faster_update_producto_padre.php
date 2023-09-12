<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerFasterUpdateProductoPadre extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER trigger_faster_update_producto_padre AFTER INSERT ON updating_faster FOR EACH ROW
        BEGIN
            /*UPDATE products
            SET stock = NEW.nuevo_stock
            WHERE id = NEW.productopadre_id;*/

            UPDATE centro_costo_products
            SET stock = NEW.nuevo_stock
            WHERE products_id = NEW.productopadre_id AND centrocosto_id = NEW.centrocosto_id;
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
        Schema::dropIfExists('DROP TRIGGER IF EXISTS trigger_faster_update_producto_padre');
    }
}