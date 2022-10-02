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
            'nombre' => $row[0],
            'funcionalidad' => $row[1],
            'tipo_prueba' => $row[2],
            'fecha_certificacion' => $row[3],
            'precondiciones' => $row[4],
            'pasos' => $row[5],
            'ola' => $row[6],
            'resultado' => $row[7],
            'aprobador' => $row[8],
            'user_id' => $row[9]
        ]);
    }
}
