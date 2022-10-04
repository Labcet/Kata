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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cp_id');
            $table->foreign('cp_id')->references('id')->on('casos_prueba');
            //$table->binary('imagen');
            $table->string('path');
            $table->text('comentario')->nullable();
            $table->timestamp('fecha_hora');
            //$table->id();
            //$table->timestamps();
        });

        DB::statement("ALTER TABLE evidencias ADD imagen MEDIUMBLOB");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evidencias');
    }
};
