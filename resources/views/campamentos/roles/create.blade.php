@extends('layouts.admin.index')

@section('title', 'Crear Rol')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Rol</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.roles.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col s12 ">
                            {!! Form::label('name','Nombre del rol:*') !!}
                            {!! Form::text('name',null,['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col s12">
                            {!! Form::label('display_name','Nombre a mostrar:*') !!}
                            {!! Form::text('display_name',null,['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col s12">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('description',null,['class'=>'materialize-textarea validate','id'=>'description','length'=>'120']) !!}
                            {!! Form::label('description','Descripción...') !!}
                        </div>

                    </div>
                        {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                        {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                        <a href="{{ route('admin.roles.index') }}"  class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                            {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                        </a>

                    {!! Form::close() !!}


                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

