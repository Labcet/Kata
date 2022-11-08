<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidente extends Model
{
    use HasFactory;

    protected $fillable = ['nombre_incidente','pasos_reproducir','system_info','estado','cp_id','fecha_solucion'];

    public $table = "incidencias";

    public $timestamps = false;
}
