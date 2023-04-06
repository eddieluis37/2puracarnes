<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDespostecerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('despostecerdos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');

         /*    $table->unsignedBigInteger('beneficiors_desposters_id')->nullable();
            $table->foreign('beneficiors_desposters_id')->references('id')->on('beneficiors_desposters'); */
            
            $table->unsignedBigInteger('beneficiocerdos_id')->nullable();
            $table->foreign('beneficiocerdos_id')->references('id')->on('beneficiocerdos');

        /* $table->unsignedBigInteger('fichatecnicas_id')->nullable();
            $table->foreign('fichatecnicas_id')->references('id')->on('fichatecnicas');*/

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

            $table->decimal('porcdesposte', $precision = 18, $scale = 2);           
            $table->decimal('peso', $precision = 18, $scale = 2);
            $table->decimal('total', $precision = 18, $scale = 2);
            $table->decimal('sell_price', $precision = 18, $scale = 2);
            $table->decimal('totalventa', $precision = 18, $scale = 2);
            $table->decimal('porcventa', $precision = 18, $scale = 2);
            $table->decimal('costototal', $precision = 18, $scale = 2);

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
        Schema::dropIfExists('despostecerdos');
    }
}
