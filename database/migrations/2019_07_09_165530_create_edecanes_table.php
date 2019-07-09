<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEdecanesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('edecanes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->nullable()->default(null);
            $table->string('imagen')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->integer('state')->nullable()->default(1);
            
            $table->integer('promotor')->nullable()->default(null)->unsigned();
            $table->foreign('promotor')->references('id')->on('users')->onDelete('cascade');

            $table->integer('edecan')->nullable()->default(null)->unsigned();
            $table->foreign('edecan')->references('id')->on('users')->onDelete('cascade');

            $table->integer('evento')->nullable()->default(null)->unsigned();
            $table->foreign('evento')->references('id')->on('eventos_funciones')->onDelete('cascade');
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
        Schema::dropIfExists('edecanes');
    }
}
