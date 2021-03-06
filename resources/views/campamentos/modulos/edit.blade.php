@extends('layouts.admin.index')

@section('title', 'Editar Modulo')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Modulo</h5>
                <div class="card-content ">
                    @include('alert.success')
                    {!! Form::model($modulo,['route'=>['admin.modulos.update',$modulo->id], 'method'=>'PUT'])  !!}
                    <div class="col s12">


                        <div class="row">
                            <div class="input-field col s8 ">
                                {!! Form::label('modulo','Modulo:') !!}
                                {!! Form::text('modulo',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                            </div>
                            <div class="input-field col s4 ">
                                {!! Form::checkbox('modulo_river',null,$modulo->esRiver() ? true : false,['id'=>'modulo_river']) !!}
                                {!! Form::label('modulo_river','River?') !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col s6 ">
                                {!! Form::label('inicio','Inicio:') !!}
                                {!! Form::date('inicio',$modulo->inicio,['class'=>'datepicker']) !!}
                            </div>
                            <div class="input-field col s6 ">
                                {!! Form::label('fin','Fin:') !!}
                                {!! Form::date('fin',$modulo->fin,['class'=>'datepicker']) !!}
                            </div>
                        </div>


                    </div>
                    {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
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
                    $('.datepicker').addClass('invalid');
                    $flag=0;
                } else {
                    $('.datepicker').removeClass('invalid');
                    $flag=1;
                }
            }

            $('.datepicker').change(function() {
                checkDate();
            });

            $('.form_datepicker').submit(function() {
                checkDate();
                if ($flag===0){
                    return false;
                }else{
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 15 years to control year
                format : 'yyyy-mm-dd'
            });

        });
    </script>
    @endsection

