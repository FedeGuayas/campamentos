@extends('layouts.admin.index')

@section('title', 'Editar Profesor')

@section('content')

    <div class="row">
        <div class="col l10 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar Profesor</h5>
                <div class="card-content ">
                    @include('alert.request')
                    {!! Form::model($profe,['route'=>['admin.profesors.update',$profe->id], 'method'=>'PUT']) !!}
                    <div class="col s12">
                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user prefix"></i>
                            {!! Form::label('nombres','Nombres:*') !!}
                            {!! Form::text('nombres',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('apellidos','Apellidos:*') !!}
                            {!! Form::text('apellidos',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                        </div>

                        <div class="input-field col l4 m4 s12">
                            {!! Form::label('num_doc','Número del documento:*') !!}
                            {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
                        </div>
                    </div>
                </div>
                {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                <a href="{{ route('admin.profesors.index') }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
                {!! Form::close() !!}
            </div><!--/.card content-->
        </div><!--/.card panel-->
    </div><!--/.row-->

@endsection
