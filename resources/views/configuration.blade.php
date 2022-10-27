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
                                <a type="button" id="addola" class="btn btn-primary" style="background: #ffd000; border: none;" href="{{ route('addola', $var->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd"></path>
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
                    <form class="row g-3" action="{{url('updateola')}}" method="post" >
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput1" class="form-label">Variable</label>
                            <!--<input type="text" class="form-control" id="variable" name="variable" value="Ola" disabled>-->
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