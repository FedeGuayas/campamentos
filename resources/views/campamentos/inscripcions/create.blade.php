@extends('layouts.admin.index')

@section('title', 'Indcripción')

@section('content')


    <div class="row">
        <div class="col l12">
            <div class="card-panel">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="#inscripcion"><h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Inscripción</h5></a></li>
                    <li class="tab col s4"><a href="#test2"><h5><i class="fa fa-shopping-cart" aria-hidden="true"></i> Detalle</h5></a></li>
                    <li class="tab col s4 "><a href="#test3"><h5><i class="fa fa-money" aria-hidden="true"></i> Facturación</h5></a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col  s12">
            <div class="card-panel">
                {{--<h5 class="header teal-text text-darken-2">Inscripción</h5>--}}
                <div id="inscripcion">
                    <br>
                    @include('campamentos.inscripcions.partials.inscripcion')
                </div>


            </div><!--/.card panel-->
        </div><!--/.card col-->
    </div><!--/.row-->

@endsection

@section('scripts')

    <script>

       $("#modulo_id").material_select();

       $(document).ready(function () {
           // para ventana modal de busqueda
           $('.modal-representante').leanModal({
               dismissible: false, // Modal can be dismissed by clicking outside of the modal
               opacity: .5, // Opacity of modal background
               in_duration: 300, // Transition in duration
               out_duration: 200, // Transition out duration
               starting_top: '40%', // Starting top style attribute
               ending_top: '2%', // Ending top style attribute

            });
       });



    </script>

    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdown.js") }}" type="text/javascript"></script>

@endsection