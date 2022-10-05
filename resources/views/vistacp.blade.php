@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 20px;">
                <div class="card-header">Información del Caso de Prueba</div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="testCaseNombre">Caso de Prueba</label>
                        <input type="text" class="form-control" id="testCaseNombre" value="{{ $cp->nombre }}" readonly>
                    </div>
                    <div class="form-group">
                        <label for="testCaseFuncionalidad">Funcionalidad</label>
                        <input type="text" class="form-control" id="testCaseFuncionalidad" value="{{ strtoupper($cp->funcionalidad) }}" readonly>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="testCaseTipo">Tipo de Prueba</label>
                                <input type="text" class="form-control" id="testCaseTipo" value="{{ $cp->tipo_prueba }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="testCaseFechaCertificacion">Fecha de Certificación</label>
                                <input type="text" class="form-control" id="testCaseFechaCertificacion" value="{{ $cp->fecha_certificacion }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="testCasePrecondiciones">Precondiciones</label>
                        <textarea type="text" class="form-control" id="testCasePrecondiciones" rows="5" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="testCasePasos">Pasos</label>
                        <textarea type="text" class="form-control" id="testCasePasos" rows="5" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="testCaseOla">Ola</label>
                                <input type="text" class="form-control" id="testCaseOla" value="{{ $cp->ola }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseResultado">Resultado</label>
                                <input type="text" class="form-control" id="testCaseResultado" value="{{ strtoupper($cp->resultado) }}" readonly>
                            </div>
                            <div class="col-4">
                                <label for="testCaseAprobador">Aprobador</label>
                            <input type="text" class="form-control" id="testCaseAprobador" value="{{ strtoupper($cp->aprobador) }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <evidencias-component :id-cp="{{ $cp->id }}" :resultado-cp="'{{ $cp->resultado }}'"></evidencias-component>
        </div>
    </div>
</div>

@endsection

@push('other-scripts')

<script type="text/javascript">
    $(document).ready(function(){

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

        /* PASOS */

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
    });
</script>

@endpush

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>