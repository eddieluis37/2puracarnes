<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTriggerTransferUpdateProductoHijo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE TRIGGER trigger_transfer_update_producto_hijo AFTER INSERT ON updating_transfer_details FOR EACH ROW
            BEGIN                
                
                DECLARE centrocostoOrigenId INT;

                select shop.centrocostoOrigen_id INTO centrocostoOrigenId FROM updating_transfer AS shop WHERE shop.id = NEW.updating_transfer_id;
                
                UPDATE centro_costo_products
                SET stock = NEW.newstock
                WHERE products_id = NEW.products_id AND centrocosto_id = centrocostoOrigenId;

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
        Schema::dropIfExists('trigger_transfer_update_producto_hijo');
    }
}
