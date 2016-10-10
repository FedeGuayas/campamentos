@extends('layouts.admin.index')

@section('title', 'Editar Modulo')


@section('head')
        <!-- ClockPicker Stylesheet -->
{!! Html::style('plugins/materializeclockpicker/css/materialize.clockpicker.css') !!}
@endsection

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Modulo</h5>
                <div class="card-content ">
                    @include('alert.success')
                    {!! Form::model($horario,['route'=>['admin.horarios.update',$horario->id], 'method'=>'PUT'])  !!}
                    <div class="col s12">

                        <div class="input-field col l4 m4 s12 ">
                            <i class="fa fa-clock-o prefix" aria-hidden="true"></i>
                            {!! Form::label('start_time','Hora inicio:') !!}
                            {!! Form::text('start_time',null,['class'=>'validate timepicker', 'data-align'=>'top', 'data-autoclose'=>'true']) !!}
                        </div>

                        <div class="input-field col l4 m4 s12 ">
                            <i class="fa fa-clock-o prefix" aria-hidden="true"></i>
                            {!! Form::label('end_time','Hora fin:') !!}
                            {!! Form::text('end_time',null,['class'=>'timepicker', 'data-align'=>'top', 'data-autoclose'=>'true']) !!}
                        </div>

                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.horarios.index') }}" class="tooltipped" data-position="bottom"
                       data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}


                </div><!--/.card content-->.
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

@section('scripts')

    {{--ClockPicker script--}}
    {!! Html::script('plugins/materializeclockpicker/js/materialize.clockpicker.js') !!}

    <script type="text/javascript">

        $(document).ready(function () {
            $('.timepicker').pickatime({

                donetext: 'Hecho',      // done button text
                autoclose: false,      // auto close when minute is selected
                twelvehour: false,      // change to 12 hour AM/PM clock from 24 hour
                vibrate: true         // vibrate the device when dragging clock hand

            });
        });

    </script>

@endsection