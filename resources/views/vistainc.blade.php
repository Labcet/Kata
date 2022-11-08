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
                <div class="card-header"><strong>Información del Incidente</strong></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="modalNombreIncidente" class="form-label">Nombre del Incidente</label>
                        <input type="text" class="form-control" id="modalNombreIncidente" value="{{ $inc[0]->nombre_incidente }}" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="modalPasosIncidente" class="form-label">Pasos a Reproducir</label>
                        <textarea type="text" class="form-control" id="modalPasosIncidente" rows="4" readonly>{{ $inc[0]->pasos_reproducir }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="modalSystemIncidente" class="form-label">System Info</label>
                        <textarea type="text" class="form-control" id="modalSystemIncidente" rows="4" readonly>{{ $inc[0]->system_info }}</textarea>
                    </div>
                    <div class="mb-3">
                        <div class="row">
                            <div class="col-6">
                                <label for="modalEstadoIncidente" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="modalEstadoIncidente" value="{{ $inc[0]->estado }}" readonly>
                            </div>
                            <div class="col-6">
                                <label for="modalFechaSolucionIncidente" class="form-label">Fecha Solución</label>
                                <input type="text" class="form-control" id="modalFechaSolucionIncidente" value="{{ $inc[0]->fecha_solucion }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <evidencias-component :id-cp="null" :resultado-cp="'{{ strtoupper($inc[0]->estado) }}'" :id-inc="{{ $inc[0]->id }}"></evidencias-component>

            @if(strtoupper($inc[0]->estado) == 'PENDIENTE')
                <div class="card" style="margin-bottom:100px; text-align: center;">
                    <div class="card-header"><strong>Decisíón</strong></div>
                    <div class="card-body">
                        <a type="button" id="resuelto" class="btn btn-primary" style="background: #019500; border: none; margin-right: 10px;" href="{{ route('resueltoinc', $inc[0]->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Resuelto" onclick="return confirm('¿Está seguro(a)?')">
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
    
</script>

@endpush

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>