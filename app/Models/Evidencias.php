<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencias extends Model
{
    use HasFactory;

    protected $fillable = ['cp_id','inc_id','imagen','path','comentario','fecha_hora', 'ola'];

    public $table = "evidencias";

    public $timestamps = false;
}
