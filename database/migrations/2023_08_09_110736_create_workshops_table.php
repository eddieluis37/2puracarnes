<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshops', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');

            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categories');

            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');

            $table->unsignedBigInteger('meatcut_id')->nullable();           
            $table->foreign('meatcut_id')->references('id')->on('meatcuts')->onDelete("cascade");

            $table->decimal('peso_producto_padre', 18, 2)->default(0);

            $table->decimal('merma', 18, 2)->default(0);

            $table->decimal('nuevo_stock_padre', 18, 2)->default(0);
            $table->enum('inventario', ['pending', 'added'])->default('pending');
            $table->date('fecha_workshop');
            $table->date('fecha_cierre')->nullable();

            $table->boolean('status')->parent_select()->default(true)->nullable();         
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('workshops');
    }
}
