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