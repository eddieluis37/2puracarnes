<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThirdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thirds', function (Blueprint $table) {
            $table->id();
            /* 
            $table->unsignedBigInteger('agreement_id')->nullable();
            $table->foreign('agreement_id')->references('id')->on('agreements'); */

            $table->string('name', 250);

            $table->unsignedBigInteger('type_identification_id');
            $table->foreign('type_identification_id')->references('id')->on('type_identifications');

            $table->bigInteger('identification')->unique()->nullable();

            $table->integer('digito_verificacion')->nullable()->default(0);

            $table->unsignedBigInteger('office_id');
            $table->foreign('office_id')->references('id')->on('offices');

            $table->unsignedBigInteger('type_regimen_iva_id');
            $table->foreign('type_regimen_iva_id')->references('id')->on('type_regimen_ivas');

            $table->string('direccion', 150);

            $table->string('direccion1', 150)->nullable();
            $table->string('direccion2', 150)->nullable();
            $table->string('direccion3', 150)->nullable();
            $table->string('direccion4', 150)->nullable();

            $table->unsignedBigInteger('province_id');
            $table->foreign('province_id')->references('id')->on('provinces');

            $table->string('celular', 50);

            $table->string('nombre_contacto', 150);

            $table->boolean('status')->parent_select()->default(true);

            $table->string('correo', 100)->nullable();

            $table->boolean('cliente')->parent_select()->default(true)->nullable();
            $table->boolean('proveedor')->parent_select()->default(false)->nullable();
            $table->boolean('vendedor')->parent_select()->default(false)->nullable();
            $table->boolean('domiciliario')->parent_select()->default(false)->nullable();

            $table->unsignedTinyInteger('porc_descuento')->nullable()->default(0);

            $table->unsignedBigInteger('listaprecio_nichoid')->nullable();
            //$table->foreign('listaprecio_nichoid')->references('id')->on('listaprecios');

            $table->unsignedBigInteger('listaprecio_genericid')->nullable();
            //$table->foreign('listaprecio_genericid')->references('id')->on('listaprecios');

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
        Schema::dropIfExists('thirds');
    }
}
