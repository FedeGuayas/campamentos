@extends('layouts.admin.index')

@section('title', 'Editar Dias')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Dias</h5>
                <div class="card-content ">
                    @include('alert.success')
                    {!! Form::model($dia,['route'=>['admin.dias.update',$dia->id], 'method'=>'PUT'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            {!! Form::label('dia','Dias:') !!}
                            {!! Form::text('dia',null,['class'=>'validate']) !!}
                        </div>

                    </div>
                    {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.dias.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
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

