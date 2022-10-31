@extends('layout')
  
@section('content')
<div class="container"><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <metricas-component :id-user="{{ Auth::user()->id }}"></metricas-component>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <td colspan="2"> Resumen General </td>
                </thead>
                <tbody>
                    <tr>
                        <td>Pendientes</td>
                        <td>{{ $pendientes }}</td>
                    </tr>
                    <tr>
                        <td>Desestimados</td>
                        <td>{{ $desestimados }}</td>
                    </tr>
                    <tr>
                        <td>Fallidos</td>
                        <td>{{ $fallidos }}</td>
                    </tr>
                    <tr>
                        <td>Exitosos</td>
                        <td>{{ $exitosos }}</td>
                    </tr>
                </tbody>
            </table><br><br>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr align='center'>
                        <td>Caso Prueba</td>
                        <td>Nombre CP</td>
                        <td>Usuario</td>
                        <td>Resultado</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cps as $key => $value)
                    <tr>
                        <td align='center'>{{ $value->caso_prueba }}</td>
                        <td>{{ $value->nombre_completo }}</td>
                        <td>{{ $value->name }}</td>
                        @if(strtoupper($value->estado) == "FALLIDO")
                            <td align="center"><h6><span class="badge" style="background-color: #FF287A;">{{ strtoupper($value->estado) }}</span></h6></td>
                        @endif
                        @if(strtoupper($value->estado) == "DESESTIMADO")
                            <td align="center"><h6><span class="badge" style="background-color: #013461;">{{ strtoupper($value->estado) }}</span></h6></td>
                        @endif
                        @if(strtoupper($value->estado) == "EXITOSO")
                            <td align="center"><h6><span class="badge bg-success">{{ strtoupper($value->estado) }}</span></h6></td>
                        @endif
                        @if(strtoupper($value->estado) == "PENDIENTE")
                            <td align="center"><h6><span class="badge bg-secondary">{{ strtoupper($value->estado) }}</span></h6></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table><br><br>
        </div>
    </div>
</div>

@endsection