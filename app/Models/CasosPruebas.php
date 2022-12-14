<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CasosPruebas extends Model
{
    use HasFactory;

    protected $fillable = ['caso_prueba','proceso','producto','sub_producto','tipo_campana','destino_credito','tipo_persona','tipo_cliente','tipo_evaluacion','tipo_aprobacion','clasificacion_cliente','perfil','frecuencia','moneda','seguro_obligatorio','seguro_optativo','dato_prueba','nombre_completo','precondiciones','pasos','resultado_esperado','estado_esperado','complejidad','corebank_movil_web','equivalente_corebank','tipo_prueba','prioridad','tiempo_estimado_ejecucion','perfil_asignado','numero_ejecutores','numero_probadores','requerimiento_id','user_id'];

    public $table = "casos_prueba";

    public $timestamps = false;
}
