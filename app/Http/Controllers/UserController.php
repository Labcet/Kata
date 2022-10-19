<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Permission;
use App\Models\CasosPruebas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function userMetrics($id)
    {   

        $desestimados = CasosPruebas::where([['resultado_real', '=', 'desestimado'],['user_id', '=', $id]])->count();
        $fallidos = CasosPruebas::where([['resultado_real', '=', 'fallido'],['user_id', '=', $id]])->count();
        $exitosos = CasosPruebas::where([['resultado_real', '=', 'exitoso'],['user_id', '=', $id]])->count();
        $pendientes = CasosPruebas::where([['resultado_real', '=', 'pendiente'],['user_id', '=', $id]])->count();

        $data =[
            'labels'  => ['Desestimados', 'Fallidos', 'Exitosos', 'No Ejecutados'],
            'datasets' => [
                [
                  'backgroundColor' => ['#013461', '#FF287A','#019500', 'silver'],
                  'data' => [$desestimados, $fallidos, $exitosos, $pendientes]
                ],
            ]
        ];

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   
    public function create()
    {

       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}

