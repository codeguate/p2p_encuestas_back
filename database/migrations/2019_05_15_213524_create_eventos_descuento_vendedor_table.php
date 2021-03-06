<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventosDescuentoVendedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventos_descuento_vendedor', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->nullable()->default(null);
            $table->string('descripcion')->nullable()->default(null);
            $table->integer('type')->nullable()->default(1);
            $table->integer('state')->nullable()->default(1);

            $table->integer('evento_descuento_area')->nullable()->default(null)->unsigned();
            $table->foreign('evento_descuento_area')->references('id')->on('eventos_descuento_area')->onDelete('cascade');

            $table->integer('evento_vendedor')->nullable()->default(null)->unsigned();
            $table->foreign('evento_vendedor')->references('id')->on('eventos_vendedor')->onDelete('cascade');

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
        Schema::dropIfExists('eventos_descuento_vendedor');
    }
}
