@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Respuesta -->
            @if (session('status'))
                <div class="alert alert-danger" style="margin-top: 20px;">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor" style="display: inline-block;">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('status') }}
                    </span>
                </div>
            @endif
            <!-- -->
            <div class="card" style="margin-top: 20px;">
                <div class="card-header"><strong>Información del Caso de Prueba</strong></div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="testCaseId"><strong>Caso de Prueba</strong></label>
                                <input type="text" class="form-control" id="testCaseId" value="{{ $cp[0]->caso_prueba }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseEstadoEsperado"><strong>Estado Esperado</strong></label>
                                <input type="text" class="form-control" id="testCaseEstadoEsperado" value="{{ $cp[0]->estado_esperado }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCasePerfilAsignado"><strong>Resultado Real</strong></label>
                                <input type="text" class="form-control" id="testCasePerfilAsignado" value="{{ $cp[0]->estado }}" readonly>
                            </div>
                            <!--<div class="col-4">
                                <label for="testCaseProducto"><strong>Producto</strong></label>
                                <input type="text" class="form-control" id="testCaseProducto" value="{{ $cp[0]->producto }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseSubProducto"><strong>Sub Producto</strong></label>
                                <input type="text" class="form-control" id="testCaseSubProducto" value="{{ $cp[0]->sub_producto }}" readonly>
                            </div>-->
                        </div>
                    </div>
                    <!--<div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseDestinoCredito"><strong>Destino del Crédito</strong></label>
                                <input type="text" class="form-control" id="testCaseDestinoCredito" value="{{ $cp[0]->destino_credito }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCaseTipoCliente"><strong>Tipo Cliente</strong></label>
                                <input type="text" class="form-control" id="testCaseTipoCliente" value="{{ $cp[0]->tipo_cliente }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseTipoEvaluacion"><strong>Tipo Evaluación</strong></label>
                                <input type="text" class="form-control" id="testCaseTipoEvaluacion" value="{{ $cp[0]->tipo_evaluacion }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCaseTipoAprobacion"><strong>Tipo Aprobación</strong></label>
                                <input type="text" class="form-control" id="testCaseTipoAprobacion" value="{{ $cp[0]->tipo_aprobacion }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseClasificacionCliente"><strong>Clasificación del Cliente</strong></label>
                                <input type="text" class="form-control" id="testCaseClasificacionCliente" value="{{ $cp[0]->clasificacion_cliente }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCasePerfil"><strong>Perfil</strong></label>
                                <input type="text" class="form-control" id="testCasePerfil" value="{{ $cp[0]->perfil }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseFrecuencia"><strong>Frecuencia</strong></label>
                                <input type="text" class="form-control" id="testCaseFrecuencia" value="{{ $cp[0]->frecuencia }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCaseMoneda"><strong>Moneda</strong></label>
                                <input type="text" class="form-control" id="testCaseMoneda" value="{{ $cp[0]->moneda }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseSeguroObligatorio"><strong>Seguro Obligatorio</strong></label>
                                <input type="text" class="form-control" id="testCaseSeguroObligatorio" value="{{ $cp[0]->seguro_obligatorio }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCaseSeguroOptativo"><strong>Seguro Optativo</strong></label>
                                <input type="text" class="form-control" id="testCaseSeguroOptativo" value="{{ $cp[0]->seguro_optativo }}" readonly>
                            </div>
                        </div>
                    </div>-->
                    <div class="form-group">
                        <label for="testCaseDatoPrueba"><strong>Elemento o Dato de Prueba</strong></label>
                        <textarea type="text" class="form-control" id="testCaseDatoPrueba" rows="4" readonly>{{ $cp[0]->dato_prueba }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="testCaseNombreCompleto"><strong>Nombre Completo Caso de Prueba</strong></label>
                        <textarea type="text" class="form-control" id="testCaseNombreCompleto" rows="4" readonly>{{ $cp[0]->nombre_completo }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="testCasePrecondiciones"><strong>Precondiciones</strong></label>
                        <textarea type="text" class="form-control" id="testCasePrecondiciones" rows="4" readonly>{{ $cp[0]->precondiciones }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="testCasePasos"><strong>Pasos</strong></label>
                        <textarea type="text" class="form-control" id="testCasePasos" rows="4" readonly>{{ $cp[0]->pasos }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="testCaseResultadoEsperado"><strong>Resultado Esperado</strong></label>
                        <textarea type="text" class="form-control" id="testCaseResultadoEsperado" rows="4" readonly>{{ $cp[0]->resultado_esperado }}</textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <!--<div class="col-4">
                                <label for="testCaseEstadoEsperado"><strong>Estado Esperado</strong></label>
                                <input type="text" class="form-control" id="testCaseEstadoEsperado" value="{{ $cp[0]->estado_esperado }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseCorebankMovilWeb"><strong>Corebank/Móvil/Web</strong></label>
                                <input type="text" class="form-control" id="testCaseCorebankMovilWeb" value="{{ $cp[0]->corebank_movil_web }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseTipoPrueba"><strong>Tipo de Prueba</strong></label>
                                <input type="text" class="form-control" id="testCaseTipoPrueba" value="{{ $cp[0]->tipo_prueba }}" readonly>
                            </div>-->
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <!--<div class="col-6">
                                <label for="testCasePerfilAsignado"><strong>Área o Perfil Asignado</strong></label>
                                <input type="text" class="form-control" id="testCasePerfilAsignado" value="{{ $cp[0]->perfil_asignado }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCasePerfilAsignado"><strong>Resultado Real</strong></label>
                                <input type="text" class="form-control" id="testCasePerfilAsignado" value="{{ $cp[0]->estado }}" readonly>
                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
            <evidencias-component :id-cp="{{ $cp[0]->id }}" :resultado-cp="'{{ strtoupper($cp[0]->estado) }}'" :id-inc="null"></evidencias-component>

            @if(strtoupper($cp[0]->estado) == 'PENDIENTE')
                <div class="card" style="margin-bottom:100px; text-align: center;">
                    <div class="card-header"><strong>Decisíón</strong></div>
                    <div class="card-body">
                        
                        <a type="button" id="desestimar" class="btn btn-primary" style="background: #013461; border: none; margin-right: 10px;" href="{{ route('desestimacp', $cp[0]->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Desestimado" onclick="return confirm('¿Está seguro(a)?')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a type="button" id="fallido" class="btn btn-primary" style="background: #FF287A; border: none; margin-right: 10px;" href="{{ route('fallacp', $cp[0]->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Fallido" onclick="return confirm('¿Está seguro(a)?')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-exclamation-diamond" viewBox="0 0 16 16">
                                <path d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                            </svg>
                        </a>
                        <a type="button" id="exitoso" class="btn btn-primary" style="background: #019500; border: none; margin-right: 10px;" href="{{ route('exitocp', $cp[0]->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Exitoso" onclick="return confirm('¿Está seguro(a)?')">
                            <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>                                   
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('other-scripts')

<script type="text/javascript">
    /*$(document).ready(function(){

        var cp = {!! json_encode($cp->toArray(), JSON_HEX_TAG) !!};
        var precond = cp.precondiciones.split(',');

        var lista = document.getElementById("testCasePrecondiciones");

        for(var i = 0; i < precond.length; i++){

            if(i==0){

                lista.value += '- ' + precond[i] + '\n';    
            } else {
                lista.value += '-' + precond[i] + '\n';
            }
            
        }

        // PASOS //

        var cp2 = {!! json_encode($cp->toArray(), JSON_HEX_TAG) !!};
        var precond2 = cp.pasos.split(',');

        var lista2 = document.getElementById("testCasePasos");

        for(var i = 0; i < precond2.length; i++){

            if(i==0){

                lista2.value += '- ' + precond2[i] + '\n';    
            } else {
                lista2.value += '-' + precond2[i] + '\n';
            }
            
        }
    });*/
</script>

@endpush

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>