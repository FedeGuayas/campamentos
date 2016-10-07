@extends('layouts.admin.index')

@section('title', 'Crear Modulo')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Modulo</h5>
                <div class="card-content ">
                    @include('alert.success')
                    {!! Form::open(['route'=>'admin.modulos.store', 'method'=>'POST', 'class'=>'form_datepicker'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            {!! Form::label('modulo','Modulo:') !!}
                            {!! Form::text('modulo',null,['class'=>'validate']) !!}
                        </div>
                        <div class="input-field col s12 ">
                            {!! Form::label('inicio','Inicio:') !!}
                            {!! Form::date('inicio',null,['class'=>'datepicker']) !!}
                        </div>
                        <div class="input-field col s12 ">
                            {!! Form::label('fin','Fin:') !!}
                            {!! Form::date('fin',null,['class'=>'datepicker']) !!}
                        </div>

                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.modulos.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>

                    {!! Form::close() !!}


                </div><!--/.card content-->.
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            //valida el datepicker k no este vacio
            function checkDate() {

                if ($('.datepicker').val() == '') {
                    $('.datepicker').addClass('invalid')
                    $flag=0;
                } else {
                    $('.datepicker').removeClass('invalid')
                    $flag=1;
                }
            }

            $('.datepicker').change(function() {
                checkDate();
            });

            $('.form_datepicker').submit(function() {
                checkDate();
                if ($flag==0){
                    return false;
                }else{
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 50, // Creates a dropdown of 15 years to control year
            format: 'yyyy/mm/dd'
            });

        });
    </script>
    @endsection

