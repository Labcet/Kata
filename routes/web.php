<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CasosPruebasController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\VariableController;
use App\Http\Controllers\IncidenteController;
use App\Http\Controllers\Controller;
use App\Models\CasosPruebas;
use App\Models\Evidencias;
use App\Models\Variable;
use App\Models\Ola;
use App\Models\Incidente;
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
Route::get('dashboard/{filtro}', [AuthController::class, 'dashboard'])->name('dashboard'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

/* RUTA DE IMPORTACION */

Route::get('/import', [CasosPruebasController::class, 'import'])->name('importar');

/* RUTA PDF */

Route::get('pdf/{id}', [PdfController::class, 'index'])->name('pdf');

/* RUTA VISTA CP */

Route::get('vistacp/{id}', [CasosPruebasController::class, 'index'])->name('vistacp');

/* RUTA VISTA INCIDENTE */

Route::get('vistainc/{id}', [IncidenteController::class, 'show'])->name('vistainc');

/* RUTA CONFIGURATION */

Route::get('configuration', [Controller::class, 'configuration'])->name('configuration');

/* RUTA ANALYTICS */

Route::get('analytics', [Controller::class, 'analytics'])->name('analytics');

/* RUTA INCIDENTES */

Route::get('incidentes/{id}', [IncidenteController::class, 'index'])->name('incidentes');

/* RUTAS BOTONES ACEPTACION/OBSERVACION */

Route::get('/desestimacp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    $ola = Variable::where('variable', 'Ola')->first();

    if(Evidencias::where([['cp_id', '=', $idCP],['ola', '=', $ola->valor]])->count() > 0){

        // Actualizamos el estado del CP en la tabla Ola

        Ola::where([['cp_id', '=', $idCP],['num_ola', '=', $ola->valor]])
        ->update([
            'estado' => 'Desestimado',
            'fecha_ejecucion' => date('Y-m-d H:i:s')
        ]);

        // Actualizamos el estado temporal del CP (Lo liberamos)

        CasosPruebas::where('id', $idCP)
                        ->update(['estado_temporal' => '0']);

        return redirect()->route('dashboard', ['filtro' => 'all']);

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }

    
})
    ->name('desestimacp');

Route::get('/fallacp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    $ola = Variable::where('variable', 'Ola')->first();

    if(Evidencias::where([['cp_id', '=', $idCP],['ola', '=', $ola->valor]])->count() > 0){

        // Actualizamos el estado del CP en la tabla Ola

        Ola::where([['cp_id', '=', $idCP],['num_ola', '=', $ola->valor]])
        ->update([
            'estado' => 'Fallido',
            'fecha_ejecucion' => date('Y-m-d H:i:s')
        ]);

        // Actualizamos el estado temporal del CP (Lo liberamos)

        CasosPruebas::where('id', $idCP)
                        ->update(['estado_temporal' => '0']);

        return redirect()->route('dashboard', ['filtro' => 'all']);

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }
})
    ->name('fallacp');

Route::get('/exitocp/{idCP}', function ($idCP){

    date_default_timezone_set('America/Lima');

    $ola = Variable::where('variable', 'Ola')->first();

    if(Evidencias::where([['cp_id', '=', $idCP],['ola', '=', $ola->valor]])->count() > 0){

        // Actualizamos el estado del CP en la tabla Ola

        Ola::where([['cp_id', '=', $idCP],['num_ola', '=', $ola->valor]])
        ->update([
            'estado' => 'Exitoso',
            'fecha_ejecucion' => date('Y-m-d H:i:s')
        ]);

        // Actualizamos el estado temporal del CP (Lo liberamos)

        CasosPruebas::where('id', $idCP)
                        ->update(['estado_temporal' => '0']);

        return redirect()->route('dashboard', ['filtro' => 'all']);

    } else {

        return redirect()->route('vistacp',$idCP)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }
})
    ->name('exitocp');

Route::get('/addola/{idVar}', function ($idVar){


    // Actualizamos la variable Ola

    $ola = Variable::where('variable', 'Ola')->first();
    $new_value = $ola->valor+1;

    Variable::where('id', $idVar)
    ->update([
        'valor' => $new_value
    ]);

    //Agregamos los mismos CP's con la nueva ola

    $cps = CasosPruebas::all();

    foreach ($cps as $key => $cp) {
        
        DB::table('olas')->insert([
            'cp_id' => $cp->id,
            'num_ola' => $new_value,
            'estado' => 'Pendiente'
        ]);
    }

    return redirect('/configuration');
})
    ->name('addola');


/* RUTA MERGE PDF */

Route::get('/reporteusuario/{id}', [PdfController::class, 'mergePDF'])->name('reporteusuario');

/* RUTA GENERAL PDF */

Route::get('/reportegeneral', [PdfController::class, 'generalPDF'])->name('reportegeneral');

/* RUTA PARA GENERAR REPORTE */

Route::post('/generatereporte', [PdfController::class, 'generatePDF'])->name('generatereporte');

/* ACTUALIZAR OLA */

Route::post('updateola', [VariableController::class, 'updateOla'])->name('updateola');

/* REGISTRAR INCIDENTE */

Route::post('registerincidente', [IncidenteController::class, 'store'])->name('registerincidente');

/* RESOLVER INCIDENTE */

Route::get('/resueltoinc/{idInc}', function ($idInc){

    date_default_timezone_set('America/Lima');

    //$ola = Variable::where('variable', 'Ola')->first();

    if(Evidencias::where([['inc_id', '=', $idInc]])->count() > 0){

        // Actualizamos el estado del INC en la tabla Incidentes

        Incidente::where([['id', '=', $idInc]])
        ->update([
            'estado' => 'EXITOSO',
            'fecha_solucion' => date('Y-m-d H:i:s')
        ]);

        return redirect()->route('dashboard', ['filtro' => 'all']);

    } else {

        return redirect()->route('vistainc',$idInc)
            ->with('status', 'Debe registrar evidencias (mínimo 1).');
    }
})
    ->name('resueltoinc');

/* PDF */

//Route::get('/pdf_index/{id}', [PdfController::class, 'index'])->name('evidencias.index');

//Route::get('/pdf/{id}', [PdfController::class, 'createPDF'])->name('evidencias.pdf');