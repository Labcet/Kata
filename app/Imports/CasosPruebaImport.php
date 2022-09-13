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
            'precondiciones' => $row[3],
            'pasos' => $row[4],
            'ola' => $row[5],
            'resultado' => $row[6],
            'aprobador' => $row[7],
            'user_id' => $row[8]
        ]);
    }
}
