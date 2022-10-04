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
                        <td>{{ $value->resultado }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table><br><br>
        </div>
    </div>
</div>

@endsection