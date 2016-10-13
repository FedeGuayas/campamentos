@extends('layouts.admin.index')

@section('title','Programación')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Programa</h5>
                <div class="card-content ">
                    @include('alert.request')
                    @include('alert.success')
                    {!! Form::model($program,['route'=>['admin.programs.update',$program->id], 'method'=>'PUT']) !!}
                    <div class="col s12">

                        <div class="input-field col offset-l6 6 m6 s12 ">
                            {!! Form::select('modulo_id',$modulos,null, ['id'=>'modulo_id','placeholder' => 'Seleccione el Modulo...', 'value'=>"{{old()}}"]) !!}
                            {!! Form::label('modulo_id', 'Modulo:') !!}
                        </div>

                        <div class="input-field col l6 m6 s12 ">
                            {!! Form::select('escenario_id',$escenarios,null, ['id'=>'escenario_id','placeholder' => 'Seleccione el Escenario...']) !!}
                            {!! Form::label('escenario_id', 'Escenarios:') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('disciplina_id',$disciplinas,null, ['id'=>'disciplina_id','placeholder' => 'Seleccione la Disciplina...']) !!}
                            {!! Form::label('disciplina_id', 'Disciplinas:') !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('dia_id',$dias,null, ['id'=>'dia_id','placeholder' => 'Seleccione los dias...']) !!}
                            {!! Form::label('dia_id', 'Dias:') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('horario_id',$horarios,null, ['id'=>'hora_id','placeholder' => 'Seleccione el Horario...']) !!}
                            {!! Form::label('horario_id', 'Horarios:') !!}
                        </div>

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-usd prefix" aria-hidden="true"></i>
                            {!! Form::label('matricula','Matricula:') !!}
                            {!! Form::number('matricula',null,['step' => '1','min' => '1','class'=>'validate','placeholder'=>'0.00', 'required']) !!}
                        </div>
                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-usd prefix" aria-hidden="true"></i>
                            {!! Form::label('mensualidad','Mensualidad:') !!}
                            {!! Form::number('mensualidad',null,['step' => '1','min' => '1','class'=>'validate' ,'placeholder'=>'0.00', 'required']) !!}
                        </div>

                        <div class="input-field  col l6 m6 s12">
                            {!! Form::text('nivel',null,['class'=>'validate','required']) !!}
                            {!! Form::label('nivel','Nivel:') !!}
                        </div>
                        <div class="input-field  col l6 m6 s12">
                            {!! Form::label('cupos','Cupos:') !!}
                            {!! Form::number('cupos',null,['class'=>'validate' ,'placeholder'=>'0' ,'required']) !!}

                        </div>

                      </div>
                </div>
                {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                <a href="{{ route('admin.programs.index') }}" class="tooltipped" data-position="bottom" data-delay="50"
                   data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
                {!! Form::close() !!}

            </div><!--/.card content-->
        </div><!--/.card panel-->
    </div><!--/.col s12-->
    </div><!--/.row-->

@endsection


@section('scripts')
    {{--Scripts--}}
@endsection