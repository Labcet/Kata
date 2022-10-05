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
                        <td>Descartados</td>
                        <td>{{ $descartados }}</td>
                    </tr>
                    <tr>
                        <td>Observados</td>
                        <td>{{ $observados }}</td>
                    </tr>
                    <tr>
                        <td>Aprobados</td>
                        <td>{{ $aprobados }}</td>
                    </tr>
                </tbody>
            </table><br><br>
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <td>ID Caso Prueba</td>
                        <td>Usuario</td>
                        <td>Resultado</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cps as $key => $value)
                    <tr>
                        <td>{{ $value->id }}</td>
                        <td>{{ $value->name }}</td>
                        @if($value->resultado == "observado")
                            <td style="background-color: #ffd000; color: #ffffff">{{ strtoupper($value->resultado) }}</td>
                        @endif
                        @if($value->resultado == "descartado")
                            <td style="background-color: #ff287a; color: #ffffff">{{ strtoupper($value->resultado) }}</td>
                        @endif
                        @if($value->resultado == "aprobado")
                            <td style="background-color: #019500; color: #ffffff">{{ strtoupper($value->resultado) }}</td>
                        @endif
                        @if($value->resultado == "pendiente")
                            <td style="background-color: silver">{{ strtoupper($value->resultado) }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table><br><br>
        </div>
    </div>
</div>

@endsection