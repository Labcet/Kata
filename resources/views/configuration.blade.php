@extends('layout')
  
@section('content')
<div class="container"><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                Configuración General
                </div>
                <div class="card-body">
                    <form class="row g-3" method="post" action="{{url('updateola')}}">
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Variable</label>
                            <input type="text" class="form-control" id="variable" name="variable" value="Ola" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Valor</label>
                            <input type="number" class="form-control" id="valor" name="valor">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Guardar</button>
                        </div>
                    </form>
                </div>
            </div><br><br>
        </div>
    </div>
</div>

@endsection