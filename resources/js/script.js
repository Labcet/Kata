

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