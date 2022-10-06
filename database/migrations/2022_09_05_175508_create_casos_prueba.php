<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('casos_prueba', function (Blueprint $table) {
            $table->id();
            $table->text('nombre');
            $table->text('funcionalidad');
            $table->string('tipo_prueba');
            $table->date('fecha_certificacion')->nullable();
            $table->text('precondiciones');
            $table->text('pasos');
            $table->string('ola');
            $table->string('resultado');
            $table->string('aprobador');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casos_prueba');
    }
};
