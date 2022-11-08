<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use App\Models\Variable;
use Carbon\Carbon;
use File;

class EvidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ola = Variable::where('variable', 'Ola')->first();

        $evidencias = Evidencias::where('ola',$ola->valor)->get();
        return response()->json($evidencias);
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
        $ola = Variable::where('variable', 'Ola')->first();

        date_default_timezone_set('America/Lima');

        for($i = 0; $i < count($request->imagen); $i++){

            if($i == 0){

                $coment = $request->comentario;
                $fecha = Carbon::now();
            } else {

                $coment = null;
                $fecha = null;
            }
            
            $evidencias = new Evidencias;

            if($request->cp_id != null){

                $evidencias->cp_id = $request->cp_id;
                $evidencias->inc_id = null;
            } else {

                $evidencias->cp_id = null;
                $evidencias->inc_id = $request->inc_id;
            }
            
            $evidencias->imagen = $request->imagen[$i];
            $evidencias->path = 'path';
            $evidencias->comentario = $coment;
            $evidencias->fecha_hora = $fecha;
            $evidencias->ola = $ola->valor;

            $evidencias->save();
        }

        //return redirect()->route('vistacp', ['id' => encrypt($request->cp_id)]);
        

        //return count($request->imagen);

        // Kata v0.3.0

        /*$evidencias = new Evidencias;

        date_default_timezone_set('America/Lima');
        $file_name = date('Ymdhis').'_'.$request->cp_id.'_'.$request->file('imagen')->getClientOriginalName();
        $request->file('imagen')->move(public_path('/upload/'),$file_name);

        $evidencias->cp_id = $request->cp_id;
        $evidencias->imagen = '/upload/'.$file_name;
        $evidencias->path = '/upload/'.$file_name;
        $evidencias->comentario = $request->comentario;
        $evidencias->fecha_hora = Carbon::now();

        $evidencias->save();

        return redirect('/dashboard');*/
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showevidencias($id, $tipo)
    {
        $ola = Variable::where('variable', 'Ola')->first();

        if($tipo == '0'){
            
            $evidencias_cp = Evidencias::where([['cp_id', '=', $id],['ola', '=', $ola->valor]])->get();
        } else {

            $evidencias_cp = Evidencias::where([['inc_id', '=', $id]])->get();
        }
        return response()->json($evidencias_cp);
    }
    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*$ola = Variable::where('variable', 'Ola')->first();

        $evidencias_cp = Evidencias::where([['cp_id', '=', $id],['ola', '=', $ola->valor],['tipo', '=', $tipo]])->get();
        return response()->json($evidencias_cp);*/
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
        /*oficina::where('Id',$id)
            ->update([
                'nombre_oficina' => $request->nombre_oficina,
                'nombre_jefe' => $request->nombre_jefe,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado
            ]);
        
        return response()->json([
            'mensaje' => 'actualizado'
        ]);*/
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $evidencia = Evidencias::find($id);
        
        /* KATA v0.3.0
        File::delete(public_path($evidencia->path));
        */
        $evidencia->delete();

        return response()->json([
            'mensaje' => 'eliminado'
        ]);
    }
}
