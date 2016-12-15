@extends('layouts.admin.index')

@section('title','Calendario')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                {{--<h5 class="header teal-text text-darken-2">Calendario:</h5>--}}
                <div class="card-content ">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title ">Calendario</h3>
                            </div>
                            <div class="panel-body">
                                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                                    <thead>
                                    <th>Escenario</th>
                                    <th>Disciplina</th>
                                    <th>Modulo</th>
                                    </thead>
                                    <tr>
                                        <td>{{$escenario->escenario}}</td>
                                        <td>{{$disciplina->disciplina}}</td>
                                        <td>{{$modulo->modulo}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    <div class="col s12">
                        @include('alert.request')
                        {!! Form::open(['route'=>'admin.calendars.store', 'method'=>'POST'])  !!}
                        {!! Form::hidden('program_id',$program->id) !!}
                        <div class="input-field col l6 m6 s12 ">
                            {!! Form::select('dia_id',$dias,null, ['id'=>'dia_id','placeholder' => 'Seleccione los dias...']) !!}
                            {!! Form::label('dia_id', 'Dias:') !!}
                        </div>
                        <div class="input-field col l6 m6 s12 ">
                            {!! Form::select('horario_id',$horarios,null, ['id'=>'horario_id','placeholder' => 'Seleccione los horarios...']) !!}
                            {!! Form::label('horario_id', 'Horario:') !!}
                        </div>

                        <div class="input-field col l4 m4 s12 ">
                            <i class="fa fa-usd prefix" aria-hidden="true"></i>
                            {!! Form::label('mensualidad','Mensualidad:') !!}
                            {!! Form::number('mensualidad',null,['step' => '0.01','min' => '1','class'=>'validate','placeholder'=>'0.00','required']) !!}
                        </div>
                        <div class="input-field  col l4 m4 s12">
                            {!! Form::label('cupos','Cupos:') !!}
                            {!! Form::number('cupos',null,['class'=>'validate' ,'placeholder'=>'0']) !!}
                        </div>
                        <div class="input-field  col l4 m4 s12">
                            {!! Form::select('nivel',['BASICO' => 'BASICO', 'INTERMEDIO' => 'INTERMEDIO', 'AVANZADO' => 'AVANZADO'],null,['placeholder' => 'Seleccione...','id'=>'nivel']) !!}
                            {!! Form::label('nivel','Nivel:') !!}
                        </div>

                        <div class="range-field  col l4 m4 s12">
                            {!! Form::label('init_age','Edad inicial:') !!}
                            {!! Form::number('init_age',null,['class'=>'validate','required']) !!}
                        </div>
                        <div class="range-field  col l4 m4 s12">
                            {!! Form::label('end_age','Edad final:') !!}
                            {!! Form::number('end_age',null,['class'=>'validate','required']) !!}
                        </div>
                        <div class="input-field col l4 m4 s12 ">
                            {!! Form::select('profesor_id',$profesores,null, ['id'=>'profesor_id','placeholder' => 'Seleccione profesor...']) !!}
                            {!! Form::label('profesor_id', 'Profesor:') !!}
                        </div>

                    </div>

                </div>
                {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                <a href="{{ route('admin.programs.index') }}" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
                {!! Form::close() !!}

            </div><!--/.card content-->
        </div><!--/.card panel-->
    </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

