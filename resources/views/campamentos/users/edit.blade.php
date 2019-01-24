@extends('layouts.admin.index')

@section('title', 'Editar Usuario')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Editar {{ $uri=='admin/users/{users}/edit' ? 'Usuario' : 'Trabajador'  }}</h5>
                <div class="card-content ">

                    {!! Form::model($user,['route'=>['admin.users.update',$user->id], 'method'=>'PUT'])  !!}
                    {!! Form::hidden('uri',$uri,['id'=>'uri']) !!}

                    <div class="col s12">
                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user prefix"></i>
                            {!! Form::label('first_name','Nombres:*') !!}
                            {!! Form::text('first_name',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('last_name','Apellidos:*') !!}
                            {!! Form::text('last_name',null,['class'=>'validate','style'=>'text-transform:uppercase']) !!}
                        </div>

                    </div>

                    <div class="col s12">

                        <div class="input-field col l6 m6 s12">
                            <i class="fa fa-envelope prefix"></i>
                            {!! Form::label('email','Correo:*') !!}
                            {!! Form::email('email',null,['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            <i class="fa fa-lock prefix"></i>
                            {!! Form::label('password','Contraseña:*') !!}
                            {!! Form::password('password',['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('escenario_id', $escenarios,null, ['id'=>'escenario_id','placeholder'=>'Seleccione ...']) !!}
                            {!! Form::label('escenario_id', 'Punto cobro:*') !!}
                        </div>

                    </div>
                    {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                    {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    <a href="{{ route('admin.users.index') }}">
                        {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                    </a>
                    {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection