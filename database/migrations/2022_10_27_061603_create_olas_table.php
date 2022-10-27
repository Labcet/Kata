<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOlasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('olas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cp_id');
            $table->foreign('cp_id')->references('id')->on('casos_prueba');
            $table->integer('num_ola');
            $table->string('estado');
            $table->timestamp('fecha_ejecucion')->nullable();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('olas');
    }
}
