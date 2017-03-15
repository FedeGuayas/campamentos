@extends('layouts.admin.index')

@section('title', 'Inscripción')

@section('content')

    <div class="row">
        <h5 class="header teal-text text-darken-2">Nueva Inscripción</h5>
        @include('alert.request')
        @include('alert.success')
        @include('campamentos.inscripcions.partials.re-inscripcion')
    </div><!--/.row-->

@endsection

@section('scripts')

    <script>
        $(function () {
            //prevenir que al dar enter se envie el formulario
            $(".form_noEnter").keypress(function (e) {
                if (e.width == 13) {
                    return false;
                }
            });
        });


    </script>



@endsection