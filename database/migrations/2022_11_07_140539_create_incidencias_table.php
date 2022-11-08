<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incidencias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_incidente');
            $table->text('pasos_reproducir');
            $table->text('system_info');
            $table->text('estado');
            $table->unsignedBigInteger('cp_id')->nullable();
            $table->foreign('cp_id')->references('id')->on('casos_prueba');
            $table->timestamp('fecha_solucion')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('incidencias');
    }
}
