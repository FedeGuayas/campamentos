@extends('layouts.admin.index')

@section('title', 'Crear Horario')

@section('head')

@endsection

@section('content')

    <div class="container">
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker6'>
                    <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
        <div class='col-md-5'>
            <div class="form-group">
                <div class='input-group date' id='datetimepicker7'>
                    <input type='text' class="form-control" />
                <span class="input-group-addon">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
                </div>
            </div>
        </div>
    </div>







    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Horario</h5>
                <div class="card-content ">
                    @include('alert.success')
                    {!! Form::open(['route'=>'admin.horarios.store', 'method'=>'POST'])  !!}
                    <div class="col s12">



                        <div class="input-field col s12 ">
                            {!! Form::label('start_time','Hora inicio:') !!}
                            {!! Form::text('start_time',null,['class'=>'start_timepicker']) !!}
                        </div>
                        <div class="input-field col s12 ">
                            {!! Form::label('fin','Hora fin:') !!}
                            {!! Form::text('fin',null,['class'=>'validate']) !!}
                        </div>

                    </div>
                    {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.horarios.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>

                    {!! Form::close() !!}


                </div><!--/.card content-->.
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

@section('scripts')

    <script type="text/javascript">
        $(document).ready(function() {
            $(function () {
                $('#datetimepicker6').datetimepicker();
                $('#datetimepicker7').datetimepicker({
                    useCurrent: false //Important! See issue #1075
                });
                $("#datetimepicker6").on("dp.change", function (e) {
                    $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
                });
                $("#datetimepicker7").on("dp.change", function (e) {
                    $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
                });
            });
        });
    </script>

    {{--<script type="text/javascript">--}}
        {{--$(function () {--}}
            {{--$('.start_timepicker').datetimepicker({--}}
                {{--format: 'LT',--}}
                {{--icons: {--}}
                    {{--time: "fa fa-clock-o",--}}
                    {{--date: "fa fa-calendar",--}}
                    {{--up: "fa fa-arrow-up",--}}
                    {{--down: "fa fa-arrow-down"--}}
                {{--}--}}
            {{--});--}}
        {{--});--}}
    {{--</script>--}}

    @endsection

