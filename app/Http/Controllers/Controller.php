<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use App\Models\Variable;
use App\Models\Ola;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function analytics()
    {

        if(Auth::check()){

            $user = Auth::user();

            if($user->rol == "administrador" || $user->rol == "visualizador"){

                $ola = Variable::where('variable', 'Ola')->first();

                $cps = DB::table('casos_prueba')
                            ->join('users', 'casos_prueba.user_id', '=', 'users.id')
                            ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                            ->select('casos_prueba.caso_prueba', 'casos_prueba.nombre_completo', 'users.name', 'olas.estado')
                            ->where([['olas.num_ola', '=', $ola->valor]])
                            ->get();

                $desestimados = Ola::where([['estado', '=', 'Desestimado'],['num_ola', '=', $ola->valor]])->count();
                $fallidos = Ola::where([['estado', '=', 'Fallido'],['num_ola', '=', $ola->valor]])->count();
                $exitosos = Ola::where([['estado', '=', 'Exitoso'],['num_ola', '=', $ola->valor]])->count();
                $pendientes = Ola::where([['estado', '=', 'Pendiente'],['num_ola', '=', $ola->valor]])->count();

                //$cps = CasosPruebas::all();

                return View('analytics')
                        ->with('cps', $cps)
                        ->with('desestimados', $desestimados)
                        ->with('fallidos', $fallidos)
                        ->with('exitosos', $exitosos)
                        ->with('pendientes', $pendientes);
            }

            return redirect("dashboard")->withSuccess('Opps! No tiene acceso.');
        }

        return redirect("login")->withSuccess('Opps! No tiene acceso.');
    }

    public function configuration()
    {
        if(Auth::check()){

            $user = Auth::user();

            if($user->rol == "administrador"){

                $var = Variable::all();
                return View('configuration')
                        ->with('variables', $var);
            }

            return redirect("dashboard")->withSuccess('Opps! No tiene acceso.');
        }

        return redirect("login")->withSuccess('Opps! No tiene acceso.');
    }
}
