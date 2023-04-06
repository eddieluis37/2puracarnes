<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiocerdosDespostecerdosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiocerdos_despostecerdos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('beneficiocerdos_id')->nullable();
            $table->foreign('beneficiocerdos_id')->references('id')->on('beneficiocerdos');

            $table->unsignedBigInteger('despostecerdos_id')->nullable();
            $table->foreign('despostecerdos_id')->references('id')->on('despostecerdos');

            $table->unsignedBigInteger('products_id')->nullable();
            $table->foreign('products_id')->references('id')->on('products');

     /*       $table->unsignedBigInteger('fichatecnicas_id')->nullable();
            $table->foreign('fichatecnicas_id')->references('id')->on('fichatecnicas'); */

            $table->decimal('sell_price', $precision = 18, $scale = 2);
            $table->decimal('peso', $precision = 18, $scale = 2);
            $table->decimal('porcdesposte', $precision = 18, $scale = 2);
            $table->decimal('totalventa', $precision = 18, $scale = 2);
            $table->decimal('porcventa', $precision = 18, $scale = 2);


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
        Schema::dropIfExists('beneficiocerdos_despostecerdos');
    }
}
