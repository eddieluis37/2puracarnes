<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->decimal('total',10,2);
            $table->decimal('items',10,2);
            $table->decimal('cash',10,2);
            $table->decimal('change',10,2);    
            $table->enum('status',['EFECTIVO','DATAFONO','WONPI','CREDITO','CONTRAENTREGA','TC'])->default('EFECTIVO');
            
            $table->unsignedBigInteger('user_id');           
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('third_id')->nullable();           
            $table->foreign('third_id')->references('id')->on('thirds');         
            
            $table->unsignedBigInteger('centrocosto_id')->nullable();
            $table->foreign('centrocosto_id')->references('id')->on('centro_costo');            

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
        Schema::dropIfExists('sales');
    }
}
