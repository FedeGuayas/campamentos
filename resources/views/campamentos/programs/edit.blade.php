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
                    {!! Form::model($program,['route'=>['admin.programs.update',$program->id], 'method'=>'PUT','files'=>'true']) !!}
                    <div class="col s12">

                        <div class="input-field col offset-l6 6 m6 s12 ">
                            {{--Form::select('size', array('L' => 'Large', 'S' => 'Small'), null, ['disabled' => 'disabled', placeholder' => 'Pick a size...']);--}}
                            {!! Form::select('modulo_id',$modulos,null, ['id'=>'modulo_id','placeholder' => 'Seleccione el Modulo...','required']) !!}
                            {!! Form::label('modulo_id', 'Modulo:') !!}
                        </div>


                        <div class="input-field col l6 m6 s12 ">
                            {!! Form::select('escenario_id',$escenarios,null, ['id'=>'escenario_id','placeholder' => 'Seleccione el Escenario...','required']) !!}
                            {!! Form::label('escenario_id', 'Escenarios:') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('disciplina_id',$disciplinas,null, ['id'=>'disciplina_id','placeholder' => 'Seleccione la Disciplina...','required']) !!}
                            {!! Form::label('disciplina_id', 'Disciplinas:') !!}
                        </div>

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-usd prefix" aria-hidden="true"></i>
                            {!! Form::label('matricula','Matricula:') !!}
                            {!! Form::number('matricula',null,['step' => '0.01','class'=>'validate','placeholder'=>'0.00']) !!}
                        </div>

                        <div class="file-field input-field  col l4 m6 s6">
                            @if (!isset($program->imagen))
                                <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                                {!! Form::text('imagen','Imagen',['class'=>'file-path validate']) !!}
                                {!! Form::file('imagen') !!}
                            @else
                                <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                                {!! Form::text('imagen',null,['class'=>'file-path validate']) !!}
                                {!! Form::file('imagen') !!}
                                <img src="{{ asset('img/camp/disciplinas/'.$program->imagen)}}" style='max-width: 100px' class="img-thumbnail">
                            @endif
                        </div>
                        {{--<div class="input-field  col l6 m6 s12">--}}
                        {{--{!! Form::label('cuposT','Cupos:') !!}--}}
                        {{--{!! Form::number('cuposT',null,['class'=>'validate' ,'placeholder'=>'0' ,'required']) !!}--}}
                        {{--</div>--}}

                        <div class="row">
                            <div class="col s12">
                                <blockquote>
                                    <h6>
                                        La matrícula en los módulos de River Plate incluye el precio del uniforme
                                    </h6>
                                </blockquote>
                            </div>
                        </div>

                    </div>

                </div>
                {!! Form::button('Actualizar<i class="fa fa-wrench right" aria-hidden="true"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
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