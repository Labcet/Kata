@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Respuesta -->
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 20px;">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 20 20" fill="currentColor" style="display: inline-block;">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </span>
                </div>
            @endif
            <!-- -->

            <!--@if (Auth::user()->rol == 'administrador')
            <a href="{{ route('importar') }}" class="btn btn-danger" style="margin-top: 40px;" onclick="return confirm('¿Está seguro?')">Importar Data</a>
            @endif-->

            @if (Auth::user()->rol == 'administrador')
            <div style="padding: 40px 0px;">
                <div class="card border-warning mb-3">
                    <div class="card-header bg-warning border-warning">
                        Reportes
                    </div>
                    <div class="card-body border-warning">
                        <form action="{{url('generatereporte')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-4">
                                    <label for="exampleFormControlInput1" class="form-label">Usuario</label>
                                    <select id="user" name="user" class="form-select" aria-label="Default select example">
                                        <option selected value="0">Todos</option>
                                        @foreach($users as $key => $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="exampleFormControlInput1" class="form-label">Ola</label>
                                    <select id="ola" name="ola" class="form-select" aria-label="Default select example">
                                        @for($i = 1; $i <= (int)$olas; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-4" style="display: flex; align-items: end; text-align: center;">
                                    <input type="submit" class="btn btn-danger" value="Generar Reporte">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @endif

            @if (Auth::user()->rol != 'administrador' && Auth::user()->rol != 'visualizador')
                <a href="{{ route('reporteusuario', Auth::user()->id) }}" class="btn btn-danger" style="margin-top: 40px;" target="_blank">Reporte</a>
            @endif
            <br>

            @if (Auth::user()->rol == 'administrador' || Auth::user()->rol == 'visualizador')
            <div class="filtro">
                <div class="row">
                    <div class="col-1" style="display: flex; align-items: center;">
                        <!--<label for="exampleFormControlInput1" class="form-label">Filtro</label>-->
                        <h2>Filtro: </h2>
                    </div>
                    <div class="col-3">
                        <select name="select" class="form-select" aria-label="Default select example" style="width: 200px;">
                            <option value="all" selected>Seleccione</option>
                            <option value="all">Todos</option>
                            <option value="Pendiente">Pendientes</option>
                            <option value="Desestimado">Desestimados</option>
                            <option value="Fallido">Fallidos</option>
                            <option value="Exitoso">Exitosos</option>
                        </select>
                    </div>
                </div>
            </div>
            @endif
            <br>

            <!--@if (Auth::user()->rol == 'administrador')
                <metricas-component :id-user="{{ Auth::user()->id }}"></metricas-component>
            @endif-->

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr align="center">
                        <td>Caso Prueba</td>
                        <td>Nombre Completo</td>
                        <td>Estado</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                @foreach($cps as $key => $value)
                    <tr>
                        <td align="center">{{ $value->caso_prueba }}</td>
                        <td>{{ $value->nombre_completo }}</td>
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
                        <td align="center">
                            <div>
                                @if (Auth::user()->rol != 'visualizador')
                                    <a type="button" style="background: #ffd000; border: none; margin-bottom: 10px;" class="modalCP btn btn-primary" href="{{ route('vistacp', $value->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Vista previa">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </a>
                                @endif
                                <a type="button" id="pdf" class="btn btn-primary" style="background: #ffd000; border: none; margin-bottom: 10px;" href="{{ route('pdf', $value->id) }}"  target="_blank" data-bs-toggle="tooltip" data-bs-placement="top" title="PDF">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                    </svg>                                   
                                </a><br>
                                @if (Auth::user()->rol == 'administrador')
                                <a type="button" id="pdf" class="btn btn-danger" style="border: none;" href="{{ route('incidentes', $value->id) }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Incidente">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd"></path>
                                </svg>                                  
                                </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table><br><br><br>
        </div>
    </div>
</div>

@endsection

@push('other-scripts')

<script type="text/javascript">
    
    $(document).ready(function() {
        $('.form-select[name="select"]').on('change', showSelectedValue);
        
        function showSelectedValue(event) {
            var target = $(event.target);
            //console.log(target.val() + " = " + target.find('option:selected').text());
            window.location.href = '/dashboard/' + target.val();
        }
    });

</script>

@endpush

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>