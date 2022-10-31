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
            $table->string('caso_prueba');
            $table->text('proceso')->nullable();
            $table->string('producto')->nullable();
            $table->string('sub_producto')->nullable();
            $table->string('tipo_campana')->nullable();
            $table->string('destino_credito')->nullable();
            $table->string('tipo_persona')->nullable();
            $table->string('tipo_cliente')->nullable();
            $table->string('tipo_evaluacion')->nullable();
            $table->string('tipo_aprobacion')->nullable();
            $table->string('clasificacion_cliente')->nullable();
            $table->text('perfil')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('moneda')->nullable();
            $table->text('seguro_obligatorio')->nullable();
            $table->text('seguro_optativo')->nullable();
            $table->text('dato_prueba')->nullable();
            $table->text('nombre_completo')->nullable();
            $table->text('precondiciones')->nullable();
            $table->text('pasos')->nullable();
            $table->text('resultado_esperado')->nullable();
            $table->string('estado_esperado')->nullable();
            $table->string('complejidad')->nullable();
            $table->string('corebank_movil_web')->nullable();
            $table->string('equivalente_corebank')->nullable();
            $table->string('tipo_prueba')->nullable();
            $table->string('prioridad')->nullable();
            $table->string('tiempo_estimado_ejecucion')->nullable();
            $table->string('perfil_asignado')->nullable();
            $table->string('numero_ejecutores')->nullable();
            $table->string('numero_probadores')->nullable();
            //$table->timestamp('fecha_ejecucion')->nullable();
            //$table->text('resultado_real')->nullable();
            $table->unsignedBigInteger('requerimiento_id');
            $table->foreign('requerimiento_id')->references('id')->on('requerimientos');
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
