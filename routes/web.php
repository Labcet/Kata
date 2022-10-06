<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CasosPruebasController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\Controller;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
//use App\Http\Controllers\Redirect

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* RUTA DE LOGIN */

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post'); 
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post'); 
Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

/* RUTA DE IMPORTACION */

Route::get('/import', [CasosPruebasController::class, 'import'])->name('importar');

/* RUTA PDF */

Route::get('pdf/{id}', [PdfController::class, 'index'])->name('pdf');

/* RUTA VISTA CP */

Route::get('vistacp/{id}', [CasosPruebasController::class, 'index'])->name('vistacp');

/* RUTA ANALYTICS */

Route::get('analytics', [Controller::class, 'analytics'])->name('analytics');

/* RUTAS BOTONES ACEPTACION/OBSERVACION */

Route::get('/desestimacp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    if(Evidencias::where('cp_id', $idCP)->count() > 0){

        CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'desestimado'
        ]);

        return redirect('/dashboard');

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }

    
})
    ->name('desestimacp');

Route::get('/fallacp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    if(Evidencias::where('cp_id', $idCP)->count() > 0){

        CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'fallido'
        ]);

        return redirect('/dashboard');

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }
})
    ->name('fallacp');

Route::get('/exitocp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    if(Evidencias::where('cp_id', $idCP)->count() > 0){

        CasosPruebas::where('id',$idCP)
        ->update([
            'fecha_certificacion' => date('Y-m-d'),
            'resultado' => 'exitoso'
        ]);

        return redirect('/dashboard');

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }
})
    ->name('exitocp');


/* RUTA MERGE PDF */

Route::get('/reporte/{id}', [PdfController::class, 'mergePDF'])->name('reporte');