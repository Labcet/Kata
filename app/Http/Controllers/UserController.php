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

        $descartados = CasosPruebas::where([['resultado', '=', 'descartado'],['user_id', '=', $id]])->count();
        $observados = CasosPruebas::where([['resultado', '=', 'observado'],['user_id', '=', $id]])->count();
        $aprobados = CasosPruebas::where([['resultado', '=', 'aprobado'],['user_id', '=', $id]])->count();
        $pendientes = CasosPruebas::where([['resultado', '=', 'pendiente'],['user_id', '=', $id]])->count();

        $data =[
            'labels'  => ['Descartados', 'Observados', 'Aprobados', 'No Ejecutados'],
            'datasets' => [
                [
                  'backgroundColor' => ['#ff287a', '#ffd000','#019500', 'silver'],
                  'data' => [$descartados, $observados, $aprobados, $pendientes]
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

