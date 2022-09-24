@extends('layout')
  
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            @if (Auth::user()->email == 'gti-echura@cajalosandes.pe')
                <a href="{{ route('importar') }}" class="btn btn-success">Importar Data</a><br><br>
            @endif
            <div class="card">
                <div class="card-header">Casos de prueba asignados</div>

                <!--<div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>-->

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <td class="col-1">ID</td>
                            <td>Nombre</td>
                            <!--<td>Funcionalidad</td>
                            <td>T. Prueba</td>
                            <td>Precondiciones</td>
                            <td>Pasos</td>
                            <td>Ola</td>
                            <td>Resultado</td>
                            <td>Aprobador</td>-->
                            <td>Acciones</td>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($cps as $key => $value)
                        <tr>
                            <td class="col-1" style="background: #13c3f3; color:#fff;">{{ $value->id }}</td>
                            <td style="background: #13c3f3; color:#fff;">{{ $value->nombre }}</td>
                            <td style="background: #13c3f3; color:#fff;">

                                <!-- delete the shark (uses the destroy method DESTROY /sharks/{id} -->
                                <!-- we will add this later since its a little more complicated than the other two buttons -->

                                <!-- show the shark (uses the show method found at GET /sharks/{id} -->
                                <!--<a class="btn btn-small btn-success" href="{{ URL::to('sharks/' . $value->id) }}">-->
                                <div class="input-group">
                                    <button type="button" style="background: #fdce04; border: none; margin-right: 10px;" class="modalCP btn btn-primary" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg" data-comp="{{ $value }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                                        </svg>
                                    </button>
                                    <a type="button" id="pdf" class="btn btn-primary" style="background: #fdce04; border: none; margin-right: 10px;" href="{{ route('pdf', $value->id) }}"  target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-pdf" viewBox="0 0 16 16">
                                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                            <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z"/>
                                        </svg>                                   
                                    </a>
                                    @if($value->aprobador == 'pendiente')
                                        <a type="button" id="observar" class="btn btn-primary" style="background: #ff287b; border: none; margin-right: 10px;" href="{{ route('observaCP', $value->id) }}" onclick="disableAprobar();">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-diamond" viewBox="0 0 16 16">
                                                <path d="M6.95.435c.58-.58 1.52-.58 2.1 0l6.515 6.516c.58.58.58 1.519 0 2.098L9.05 15.565c-.58.58-1.519.58-2.098 0L.435 9.05a1.482 1.482 0 0 1 0-2.098L6.95.435zm1.4.7a.495.495 0 0 0-.7 0L1.134 7.65a.495.495 0 0 0 0 .7l6.516 6.516a.495.495 0 0 0 .7 0l6.516-6.516a.495.495 0 0 0 0-.7L8.35 1.134z"/>
                                                <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
                                            </svg>
                                        </a>
                                        <a type="button" id="aprobar" class="btn btn-primary" style="background: #019500; border: none; margin-right: 10px;" href="{{ route('apruebaCP', $value->id) }}" onclick="disableObservar();">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2-circle" viewBox="0 0 16 16">
                                                <path d="M2.5 8a5.5 5.5 0 0 1 8.25-4.764.5.5 0 0 0 .5-.866A6.5 6.5 0 1 0 14.5 8a.5.5 0 0 0-1 0 5.5 5.5 0 1 1-11 0z"/>
                                                <path d="M15.354 3.354a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0l7-7z"/>
                                            </svg>                                    
                                        </a>
                                    @endif

                                <!--</a>-->

                                </div>

                            </td>
                            <!--<td>{{ $value->funcionalidad }}</td>
                            <td>{{ $value->tipo_prueba }}</td>
                            <td>{{ $value->precondiciones }}</td>
                            <td>{{ $value->pasos }}</td>
                            <td>{{ $value->ola }}</td>
                            <td>{{ $value->resultado }}</td>
                            <td>{{ $value->aprobador }}</td>-->
                        </tr>
                        <tr>
                            <td colspan="3">
                                <div class="container">
                                    <evidencias-component :id-cp="{{ $value->id }}" :aprobado-cp="'{{ $value->aprobador }}'"></evidencias-component>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- MODAL -->

<div class="modal fade bd-example-modal-lg" tabindex="-1" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Caso de Prueba N° <span id="testCaseId"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="testCaseNombre">Caso de Prueba</label>
                    <input type="text" class="form-control" id="testCaseNombre" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCaseFuncionalidad">Funcionalidad</label>
                    <input type="text" class="form-control" id="testCaseFuncionalidad" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCaseTipo">Tipo de Prueba</label>
                    <input type="text" class="form-control" id="testCaseTipo" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCasePrecondiciones">Precondiciones</label>
                    <input type="text" class="form-control" id="testCasePrecondiciones" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCasePasos">Pasos</label>
                    <input type="text" class="form-control" id="testCasePasos" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCaseOla">Ola</label>
                    <input type="text" class="form-control" id="testCaseOla" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCaseResultado">Resultado</label>
                    <input type="text" class="form-control" id="testCaseResultado" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <div class="form-group">
                    <label for="testCaseAprobador">Aprobador</label>
                    <input type="text" class="form-control" id="testCaseAprobador" readonly>
                    <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                </div>
                <!--<evidencias-component :id-cp="testCaseIdProp"></evidencias-component>-->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <!--<button type="button" class="btn btn-primary">Guardar</button>-->
            </div>
        </div>
    </div>
</div>
@endsection

@push('other-scripts')
<script>
    $(document).ready(function(){

        $(document).on("click", ".modalCP", function () {

            var testCaseId = $(this).data('comp');
            //testCaseIdProp = testCaseId.id;

            $("#testCaseId").text(testCaseId.id);
            //$("#idcomponent").val(testCaseId.id);
            $(".modal-body #testCaseNombre").val( testCaseId.nombre );
            $(".modal-body #testCaseFuncionalidad").val( testCaseId.funcionalidad );
            $(".modal-body #testCaseTipo").val( testCaseId.tipo_prueba );
            $(".modal-body #testCasePrecondiciones").val( testCaseId.precondiciones );
            $(".modal-body #testCasePasos").val( testCaseId.pasos );
            $(".modal-body #testCaseOla").val( testCaseId.ola );
            $(".modal-body #testCaseResultado").val( testCaseId.resultado );
            $(".modal-body #testCaseAprobador").val( testCaseId.aprobador );
        });
    });
</script>
@endpush

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>