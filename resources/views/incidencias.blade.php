@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card" style="margin-top: 40px;">
                <div class="card-header">
                    Registro de Incidentes
                </div>
                <div class="card-body">
                    <form action="{{url('registerincidente')}}" method="post">
                    @csrf 
                        <div class="mb-3" hidden>
                            <label for="inputIdCasoPrueba" class="form-label">Id CP</label>
                            <input type="text" class="form-control" id="inputCasoPrueba" value="{{ $id_cp }}" name="cp_id">
                        </div>
                        <div class="mb-3">
                            <label for="inputNombreCasoPrueba" class="form-label">Caso Prueba</label>
                            <label type="text" class="form-control" id="inputNombreCasoPrueba" readonly>{{ $nombre_cp }}</label>
                        </div>
                        <div class="mb-3">
                            <label for="inputNombreIncidente" class="form-label">Nombre de Incidente</label>
                            <input type="text" class="form-control" id="inputNombreIncidente" name="nombre_incidente" required>
                        </div>
                        <div class="mb-3">
                            <label for="inputPasos" class="form-label">Pasos a reproducir (Separando por comas)</label>
                            <textarea type="text" class="form-control" id="inputPasos" rows="4" name="pasos_reproducir" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="inputSystemInfo" class="form-label">System Info (Separando por comas)</label>
                            <textarea type="text" class="form-control" id="inputSystemInfo" rows="4" name="system_info" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('¿Está seguro(a)?')">Guardar</button>
                    </form>
                </div>
            </div>

            <table class="table table-bordered" style="margin-top: 40px; margin-bottom: 100px;">
                <thead class="table-dark">
                    <tr align="center">
                        <td>#</td>
                        <td>Nombre Incidente</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody align="center">
                    @php
                        $count = 1;
                    @endphp
                    @foreach($incidencias as $key => $var)
                    <tr>
                        <td>{{ $count++ }}</td>
                        <td>{{ $var->nombre_incidente }}</td>
                        @if(strtoupper($var->estado) == "EXITOSO")
                            <td align="center"><h6><span class="badge bg-success">{{ strtoupper($var->estado) }}</span></h6></td>
                        @endif
                        @if(strtoupper($var->estado) == "PENDIENTE")
                            <td align="center"><h6><span class="badge bg-secondary">{{ strtoupper($var->estado) }}</span></h6></td>
                        @endif
                        <td>
                            <a type="button" id="addola" class="btn btn-primary" style="background: #ffd000; border: none;" href="{{ route('vistainc', $var->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Vista previa" >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                </svg>                               
                            </a>
                            <!--<a type="button" id="addola" class="btn btn-danger" style="border: none;" href="{{ route('addola', $var->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar" onclick="return confirm('¿Está seguro?')">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>                               
                            </a>-->
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL -->

<div class="modal fade" id="incidenteModal" tabindex="-1" aria-labelledby="incidenteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información del Incidente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="modalNombreIncidente" class="form-label">Nombre del Incidente</label>
                    <input type="text" class="form-control" id="modalNombreIncidente" readonly>
                </div>
                <div class="mb-3">
                    <label for="modalPasosIncidente" class="form-label">Pasos a Reproducir</label>
                    <input type="text" class="form-control" id="modalPasosIncidente" readonly>
                </div>
                <div class="mb-3">
                    <label for="modalSystemIncidente" class="form-label">System Info</label>
                    <input type="text" class="form-control" id="modalSystemIncidente" readonly>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col-6">
                            <label for="modalEstadoIncidente" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="modalEstadoIncidente" readonly>
                        </div>
                        <div class="col-6">
                            <label for="modalFechaSolucionIncidente" class="form-label">Fecha Solución</label>
                            <input type="text" class="form-control" id="modalFechaSolucionIncidente" readonly>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('other-scripts')

<script type="text/javascript">
    
    var id = 1;
    
    window.id = @json(1);
    
    function setData(obj){

        var data = JSON.parse(obj);

        $('#modalNombreIncidente').val(data['nombre_incidente']);
        $('#modalPasosIncidente').val(data['pasos_reproducir']);
        $('#modalSystemIncidente').val(data['system_info']);
        $('#modalEstadoIncidente').val(data['estado']);
        $('#modalFechaSolucionIncidente').val(data['fecha_solucion']);
    }

</script>

@endpush