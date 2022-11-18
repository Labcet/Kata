<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pdf</title>
    <!-- Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link reel="stylescheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <style>

        table {
            border: 10px solid;
        }
    </style>

    <script>

    </script>
</head>
<body>
    <!--<header>

    </header>
    <footer>
        Información Confidencial
    </footer>-->
    <main>
        <div class="box" style="margin: 20px;">
            <table class="table table-bordered" style="border: 10px;">
                <tr>
                    <td><strong>Req:</strong></td>
                    <td colspan=3><strong>{{ $testCaseData[0]->nombre }}</strong></td>
                    <td rowspan=2 align="center" class="col-3 align-middle">
                        <img src="{{asset('/upload/andes2.jpg')}}">
                    </td>
                </tr>
                <tr>
                    <td><strong>Doc:</strong></td>
                    <td><strong>Evidencia Pruebas de Certificación QA</strong></td>
                    <td><strong>Ver.</strong></td>
                    <td><strong>{{ $testCaseData[0]->num_ola }}</strong></td>
                </tr>
            </table><br>

            <div class="box2" style="padding: 0px 40px;">
                <strong><p style="font-size: 20px;" align="justify">{{ $testCaseData[0]->caso_prueba }}: {{ $testCaseData[0]->nombre_completo }}</p></strong><br><br>

                <table class="table table-bordered" style="border: 10px;">
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Elemento o Dato de Prueba:</strong></td>
                        <td class="col-7">{{ $testCaseData[0]->dato_prueba }}</td>
                    </tr>
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Tipo de Prueba:</strong></td>
                        <td class="col-7">Funcional</td>
                    </tr>
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Precondición:</strong></td>
                        <td class="col-7">{{ $testCaseData[0]->precondiciones }}</td>
                    </tr>
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Ola y fecha de certificación real:</strong></td>
                        <td class="col-7" align="center">{{ $testCaseData[0]->num_ola }} | {{ $testCaseData[0]->fecha_ejecucion }}</td>
                    </tr>
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Resultado de prueba:</strong></td>
                        <td class="col-7" align="center">{{ $testCaseData[0]->estado }}</td>
                    </tr>
                    <tr>
                        <td class="col-5" style="background-color: #E7E7E7;"><strong>Secuencia (Pasos):</strong></td>
                        <td class="col-7">{{ $testCaseData[0]->pasos }}</td>
                    </tr>
                    @php
                        $count = 1;
                    @endphp
                    @foreach($evidenciasTestCase as $key => $value)
                    <tr>
                        <td align="center" class="col-4"><img src="{{ $value->imagen }}" alt="Image Preview" style="width: 150px; object-fit: cover;"/></td>
                        @if($count++ == 1)
                        <td rowspan="{{ $total }}" class="col-8">{{ $value->comentario }}</td>
                        @endif
                    </tr>
                    @endforeach
                    <tr>
                        <td class="col-5"><strong>Decisión Product Owner:</strong></td>
                        <td class="col-7">APROBADO | COMENTARIOS DE CRITERIOS DE ACEPTACIóN</td>
                    </tr>
                </table>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>