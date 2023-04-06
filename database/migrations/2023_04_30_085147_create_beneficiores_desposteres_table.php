<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficioresDesposteresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiores_desposteres', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('beneficiores_id')->nullable();
            $table->foreign('beneficiores_id')->references('id')->on('beneficiores');

            $table->unsignedBigInteger('desposteres_id')->nullable();
            $table->foreign('desposteres_id')->references('id')->on('desposteres');

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
        Schema::dropIfExists('beneficiores_desposteres');
    }
}
