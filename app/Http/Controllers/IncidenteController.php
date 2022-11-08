<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Incidente;
use App\Models\CasosPruebas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class IncidenteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if(Auth::check()){

            $user = Auth::user();

            if($user->rol == "administrador"){

                if($id == 0){

                    $nombre_cp = "NO EXISTE CASO DE PRUEBA";
                    $incidencias = Incidente::all();

                } else {

                    $cp = CasosPruebas::where('id', $id)->get();
                    $nombre_cp = $cp[0]->caso_prueba;
                    $incidencias = Incidente::where('cp_id', $id)->get();
                }
                /*$ola = Variable::where('variable', 'Ola')->first();

                $cp = DB::table('casos_prueba')
                        ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                        ->select('casos_prueba.*', 'olas.estado')
                        ->where([['casos_prueba.id', '=', $id],['olas.num_ola', '=', $ola->valor]])
                        ->get();

                return View('incidencias')
                        ->with('cp', $cp);*/
                return View('incidencias')
                        ->with('id_cp', $id)
                        ->with('nombre_cp', $nombre_cp)
                        ->with('incidencias', $incidencias);
            }

            return redirect("dashboard");
        }

        return redirect("login")->withSuccess('Opps! No tiene acceso.');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $incidente = new Incidente;
        $incidente->nombre_incidente = $request->nombre_incidente;
        $incidente->pasos_reproducir = $request->pasos_reproducir;
        $incidente->system_info = $request->system_info;
        $incidente->estado = 'PENDIENTE';
        $incidente->fecha_solucion = null;

        if($request->cp_id == 0){
            
            $incidente->cp_id = null;
        } else {

            $incidente->cp_id = $request->cp_id;
        }

        $incidente->save();

        //return redirect("incidentes", $request->cp_id);
        return redirect()->route('incidentes', ['id' => $request->cp_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
