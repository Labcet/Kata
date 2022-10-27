<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use App\Models\Variable;
use App\Imports\CasosPruebaImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class CasosPruebasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        //$cp = CasosPruebas::find($id);
        $ola = Variable::where('variable', 'Ola')->first();

        $cp = DB::table('casos_prueba')
                ->join('olas', 'casos_prueba.id', '=', 'olas.cp_id')
                ->select('casos_prueba.*', 'olas.estado')
                ->where([['casos_prueba.id', '=', $id],['olas.num_ola', '=', $ola->valor]])
                ->get();

        return View('vistaCP')
                ->with('cp', $cp);
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
        $cp = CasosPruebas::create($request->post());
        return view('form');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cp_id = CasosPruebas::find($id);
        return response()->json($cp_id);
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
        return 'hola';
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

    public function import()
    {
        Excel::import(new CasosPruebaImport, 'test.xlsx');

        // Insertamos data en la tabla olas

        $cps = CasosPruebas::all();

        foreach ($cps as $key => $cp) {
            
            DB::table('olas')->insert([
                'cp_id' => $cp->id,
                'num_ola' => 1,
                'estado' => 'Pendiente'
            ]);
        }

        return redirect('/dashboard')->with('success', 'All good!');
    }
}
