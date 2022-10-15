@extends('layout')
  
@section('content')
<div class="container"><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
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
                    <tr>
                        <td>ID Caso Prueba</td>
                        <td>Nombre CP</td>
                        <td>Usuario</td>
                        <td>Resultado</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cps as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->nombre }}</td>
                        <td>{{ $value->name }}</td>
                        @if($value->resultado == "fallido")
                            <td><h6><span class="badge" style="background-color: #FF287A;">{{ strtoupper($value->resultado) }}</span></h6></td>
                        @endif
                        @if($value->resultado == "desestimado")
                            <td><h6><span class="badge" style="background-color: #013461;">{{ strtoupper($value->resultado) }}</span></h6></td>
                        @endif
                        @if($value->resultado == "exitoso")
                            <td><h6><span class="badge bg-success">{{ strtoupper($value->resultado) }}</span></h6></td>
                        @endif
                        @if($value->resultado == "pendiente")
                            <td><h6><span class="badge bg-secondary">{{ strtoupper($value->resultado) }}</span></h6></td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table><br><br>
        </div>
    </div>
</div>

@endsection