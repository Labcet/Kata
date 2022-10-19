<?php

namespace App\Imports;

use App\Models\CasosPruebas;
use Maatwebsite\Excel\Concerns\ToModel;

class CasosPruebaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new CasosPruebas([
            'caso_prueba' => $row[0],
            'proceso' => $row[1],
            'producto' => $row[2],
            'sub_producto' => $row[3],
            'destino_credito' => $row[4],
            'tipo_cliente' => $row[5],
            'tipo_evaluacion' => $row[6],
            'tipo_aprobacion' => $row[7],
            'clasificacion_cliente' => $row[8],
            'perfil' => $row[9],
            'frecuencia' => $row[10],
            'moneda' => $row[11],
            'seguro_obligatorio' => $row[12],
            'seguro_optativo' => $row[13],
            'dato_prueba' => $row[14],
            'nombre_completo' => $row[15],
            'precondiciones' => $row[16],
            'pasos' => $row[17],
            'resultado_esperado' => $row[18],
            'estado_esperado' => $row[19],
            'complejidad' => $row[20],
            'corebank_movil_web' => $row[21],
            'tipo_prueba' => $row[22],
            'prioridad' => $row[23],
            'tiempo_estimado_ejecucion' => $row[24],
            'perfil_asignado' => $row[25],
            'numero_ejecutores' => $row[26],
            'numero_probadores' => $row[27],
            'fecha_ejecucion' => $row[28],
            'resultado_real' => $row[29],
            'requerimiento_id' => $row[30],
            'user_id' => $row[31]
        ]);
    }
}
