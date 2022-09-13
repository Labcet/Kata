<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class EvidenciasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $evidencias = Evidencias::all();
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
        $evidencias = new Evidencias;

        //$file_name = 'Test'.$request->file('imagen')->getClientOriginalName();
        $file_name = date('Y-m-d').'_'.$request->cp_id.'_'.$request->file('imagen')->getClientOriginalName();
        //$file_path = $request->file('imagen')->storeAs('upload', $file_name, 'public');
        //$file_path = public_path().'/upload';
        $request->file('imagen')->move(public_path('/upload/'),$file_name);
        //Storage::disk('local')->put($request->file('imagen'), 'Contents');

        $evidencias->cp_id = $request->cp_id;
        $evidencias->imagen = '/upload/'.$file_name;
        $evidencias->path = '/upload/'.$file_name;
        $evidencias->comentario = $request->comentario;
        $evidencias->fecha_hora = Carbon::now();

        $evidencias->save();

        return redirect('/dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $evidencias_cp = Evidencias::where('cp_id', $id)->get();
        return response()->json($evidencias_cp);
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
        /*$oficina = oficina::find($id);
        $oficina->delete();
        return response()->json([
            'mensaje' => 'eliminado'
        ]);*/
    }
}
