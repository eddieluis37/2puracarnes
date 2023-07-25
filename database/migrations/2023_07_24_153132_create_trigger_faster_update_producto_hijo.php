<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerFasterUpdateProductoHijo extends Migration
{

    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER trigger_faster_update_producto_hijo AFTER INSERT ON updating_faster_details FOR EACH ROW
        BEGIN
            /*UPDATE products
            SET stock = NEW.newstock
            WHERE id = NEW.products_id;*/
            
            DECLARE centrocostoId INT;

            select shop.centrocosto_id INTO centrocostoId FROM updating_transfer AS shop WHERE shop.id = NEW.updating_faster_id;
            
            UPDATE centro_costo_products
            SET stock = NEW.newstock
            WHERE products_id = NEW.products_id AND centrocosto_id = centrocostoId;

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
        Schema::dropIfExists('DROP TRIGGER IF EXISTS trigger_faster_update_producto_hijo');
    }
}
