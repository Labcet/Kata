<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ola extends Model
{
    use HasFactory;

    protected $fillable = ['cp_id','ola','resultado','fecha_ejecucion'];

    public $table = "olas";

    public $timestamps = false;
}
