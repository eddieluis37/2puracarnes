<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkshopDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('workshop_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('workshops_id')->nullable();
            $table->foreign('workshops_id')->references('id')->on('workshops');

            $table->unsignedBigInteger('users_id')->nullable();
            $table->foreign('users_id')->references('id')->on('users');    

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('peso_producto_hijo', 18, 2)->default(0)->nullable();

            $table->decimal('newstock', 18, 2)->nullable(); 

            $table->decimal('peso', 18, 2)->nullable();
            $table->decimal('porcdesposte', 18, 2)->nullable();
            $table->decimal('costo', 18, 2)->nullable();                     
            $table->decimal('costo_kilo', 18, 2)->nullable();                     
            $table->decimal('precio', 18, 2)->nullable();
            $table->decimal('totalventa', 18,2)->nullable();
            $table->decimal('total', 18, 2)->nullable();
            $table->decimal('porcventa', 18, 2)->default(0)->nullable();
            $table->string('porcutilidad', 18, 2)->nullable();
            $table->decimal('peso_acomulado', 18, 2)->nullable();
            $table->enum('status',['VALID','CANCELED'])->default('VALID');          
            
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
        Schema::dropIfExists('workshop_details');
    }
}
