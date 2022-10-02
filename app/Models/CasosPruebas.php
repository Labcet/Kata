<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasosPruebas extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','funcionalidad','tipo_prueba','fecha_certificacion','precondiciones','pasos','ola','resultado','aprobador','user_id'];

    public $table = "casos_prueba";

    public $timestamps = false;
}
