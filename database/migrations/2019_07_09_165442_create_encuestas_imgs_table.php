<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEncuestasImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('encuestas_imgs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('titulo')->nullable()->default(null);
            $table->string('imagen')->nullable()->default(null);
            $table->string('url')->nullable()->default(null);
            $table->integer('state')->nullable()->default(1);
            
            $table->integer('encuesta')->nullable()->default(null)->unsigned();
            $table->foreign('encuesta')->references('id')->on('encuestas')->onDelete('cascade');
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
        Schema::dropIfExists('encuestas_imgs');
    }
}
