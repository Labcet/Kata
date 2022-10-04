<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function analytics()
    {
        $cps = DB::table('casos_prueba')
                    ->join('users', 'casos_prueba.user_id', '=', 'users.id')
                    ->select('casos_prueba.id', 'users.name', 'casos_prueba.resultado')
                    ->get();

        $descartados = CasosPruebas::where([['resultado', '=', 'descartado']])->count();
        $observados = CasosPruebas::where([['resultado', '=', 'observado']])->count();
        $aprobados = CasosPruebas::where([['resultado', '=', 'aprobado']])->count();
        $pendientes = CasosPruebas::where([['resultado', '=', 'pendiente']])->count();

        //$cps = CasosPruebas::all();

        return View('analytics')
                ->with('cps', $cps)
                ->with('descartados', $descartados)
                ->with('observados', $observados)
                ->with('aprobados', $aprobados)
                ->with('pendientes', $pendientes);
    }
}
