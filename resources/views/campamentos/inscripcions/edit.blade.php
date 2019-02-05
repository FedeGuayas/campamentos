@extends('layouts.admin.index')

@section('title', 'Inscripción')

@section('content')

    <div class="row">
        <h5 class="header teal-text text-darken-2">Editar Inscripción</h5>
        @include('alert.request')
        @include('alert.success')
        @include('campamentos.inscripcions.partials.inscripcion-edit')
    </div><!--/.row-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            $("#modulo_id").material_select();
        });

        $(document).ready(function () {
            $('ul.tabs').tabs();
        });

        $(function () {
            //prevenir que al dar enter se envie el formulario
            $(".form_noEnter").keypress(function (e) {
                if (e.width === 13) {
                    return false;
                }
            });
        });


        //funcion crear alumno
        function buscar_curso() {
            var route = "{{route('admin.inscripcions.listCurso')}}";
            var inscripcion_id=$("#inscripcion_id").val();
            var modulo_id=$("#modulo_id").val();
            var escenario_id=$("#escenario_id").val();
            var disciplina_id=$("#disciplina_id").val();
            var horario_id=$("#horario_id").val();
            var edad=$("#edad").val();
            var costo=$("#costo_actual").val();
            var data={
                modulo_id:modulo_id,
                escenario_id:escenario_id,
                disciplina_id:disciplina_id,
                horario_id:horario_id,
                edad:edad,
                costo:costo,
                inscripcion_id:inscripcion_id
            };
            $.ajax({
                url: route,
                type: "GET",
//                headers: {'X-CSRF-TOKEN': token},
//                    contentType: 'application/x-www-form-urlencoded',
                data: data,
                success: function (resp) {
                    $("#search-result").empty().html(resp);
                },
                error: function (resp) {
                    console.log(resp.responseJSON)
                    var errors = '';
                    $.each(resp.responseJSON, function (ind, elem) {
                        errors += elem + '<br>';
                    });
                }
            });
        }

        $(document).ready(function () {
            //llamar a funcion crear alumno
            $("#filtrar_curso").on("click", function (event) {
                event.preventDefault();
                buscar_curso();
            });
        });


    </script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdown-edit.js") }}" type="text/javascript"></script>

@endsection