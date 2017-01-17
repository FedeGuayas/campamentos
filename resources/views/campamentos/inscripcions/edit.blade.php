@extends('layouts.admin.index')

@section('title', 'Inscripción')

@section('content')

    <div class="row">
        <div class="col  s12">
            <div class="card-panel">
                {{--<h5 class="header teal-text text-darken-2">Inscripción</h5>--}}
                <div id="inscripcion">
                    <br>
                    @include('campamentos.inscripcions.partials.inscripcion-edit')
                </div>
            </div><!--/.card panel-->
        </div><!--/.card col-->
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
                if (e.width == 13) {
                    return false;
                }
            });
        });


    </script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/updateCosto.js") }}" type="text/javascript"></script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdown-edit.js") }}" type="text/javascript"></script>

@endsection