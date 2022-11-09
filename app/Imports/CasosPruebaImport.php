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
        /*return new CasosPruebas([
            'caso_prueba' => $row[0],
            'proceso' => $row[1],
            'producto' => $row[2],
            'sub_producto' => $row[3],
            'tipo_campana' => $row[4],
            'destino_credito' => $row[5],
            'tipo_persona' => $row[6],
            'tipo_cliente' => $row[7],
            'tipo_evaluacion' => $row[8],
            'tipo_aprobacion' => $row[9],
            'clasificacion_cliente' => $row[10],
            'perfil' => $row[11],
            'frecuencia' => $row[12],
            'moneda' => $row[13],
            'seguro_obligatorio' => $row[14],
            'seguro_optativo' => $row[15],
            'dato_prueba' => $row[16],
            'nombre_completo' => $row[17],
            'precondiciones' => $row[18],
            'pasos' => $row[19],
            'resultado_esperado' => $row[20],
            'estado_esperado' => $row[21],
            'complejidad' => $row[22],
            'corebank_movil_web' => $row[23],
            'equivalente_corebank' => $row[24],
            'tipo_prueba' => $row[25],
            'prioridad' => $row[26],
            'tiempo_estimado_ejecucion' => $row[27],
            'perfil_asignado' => $row[28],
            'numero_ejecutores' => $row[29],
            'numero_probadores' => $row[30],
            'requerimiento_id' => $row[31],
            'user_id' => $row[32]
        ]);*/

        return new CasosPruebas([
            'caso_prueba' => $row[0],
            'proceso' => null,
            'producto' => null,
            'sub_producto' => null,
            'tipo_campana' => null,
            'destino_credito' => null,
            'tipo_persona' => null,
            'tipo_cliente' => null,
            'tipo_evaluacion' => null,
            'tipo_aprobacion' => null,
            'clasificacion_cliente' => null,
            'perfil' => null,
            'frecuencia' => null,
            'moneda' => null,
            'seguro_obligatorio' => null,
            'seguro_optativo' => null,
            'dato_prueba' => $row[1],
            'nombre_completo' => $row[2],
            'precondiciones' => $row[3],
            'pasos' => $row[4],
            'resultado_esperado' => $row[5],
            'estado_esperado' => $row[6],
            'complejidad' => null,
            'corebank_movil_web' => null,
            'equivalente_corebank' => null,
            'tipo_prueba' => null,
            'prioridad' => null,
            'tiempo_estimado_ejecucion' => null,
            'perfil_asignado' => null,
            'numero_ejecutores' => null,
            'numero_probadores' => null,
            'requerimiento_id' => $row[7],
            'user_id' => $row[8]
        ]);
    }
}
