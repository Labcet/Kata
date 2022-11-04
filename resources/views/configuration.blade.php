@extends('layout')
  
@section('content')
<div class="container"><br><br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr align="center">
                            <td>Variable</td>
                            <td>Valor</td>
                            <td>Acción</td>
                        </tr>
                    </thead>
                    <tbody align="center">
                        @foreach($variables as $key => $var)
                        <tr>
                            <td>{{ $var->variable }}</td>
                            <td>{{ $var->valor }}</td>
                            <td>
                                <a type="button" id="addola" class="btn btn-primary" style="background: #ffd000; border: none;" href="{{ route('addola', $var->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Añadir Ola" onclick="return confirm('¿Está seguro?')">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"></path>
                                    </svg>                                
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div><br><br>
            <div class="card">
                <div class="card-header">
                Configuración General
                </div>
                <div class="card-body">
                    <form class="row g-3" action="{{url('updateola')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Variable</label>
                            <select name="variable" id="variable" class="form-control">
                                @foreach($variables as $key => $var)
                                    <option value="{{ $var->variable }}">{{ $var->variable }}</option>
                                @endforeach 
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Valor</label>
                            <input type="number" class="form-control" id="valor" name="valor">
                        </div>
                        <div class="col-auto">
                            <input type="submit" class="btn btn-primary mb-3" value="Grabar">
                        </div>
                    </form>
                </div>
            </div><br><br>
        </div>
    </div>
</div>

@endsection