@extends('layouts.admin.index')

@section('title', 'Crear Usuario')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Persona</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.users.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user-plus prefix"></i>
                            {!! Form::label('nombres','Nombres:*') !!}
                            {!! Form::text('nombres',null,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('apellidos','Apellidos:*') !!}
                            {!! Form::text('apellidos',null,['class'=>'validate','required']) !!}
                        </div>


                        <div class="input-field col l6 m6 s12">
                        {!! Form::select('tipo_doc', ['CEDULA' => 'Cedula', 'PASAPORTE' => 'Pasaporte', 'NoDoc' => 'NoDoc'],null, ['id'=>'tipo_doc']) !!}
                        {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('num_doc','Número del documento:*') !!}
                            {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'],null, ['id'=>'genero']) !!}
                            {!! Form::label('genero','Género:') !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {{--{!! Form::label('fecha_nac','Fecha de Nacimiento:') !!}--}}
                            {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}

                        </div>

                        <div class="form-group">
                            {!! Form::label('Correo:') !!}
                            {!! Form::email('email',null,['class'=>'form-control','placeholder'=>'Email...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Dirección:') !!}
                            {!! Form::text('direccion',null,['class'=>'form-control','placeholder'=>'Dirección...']) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::label('Teléfono:') !!}
                            {!! Form::text('telefono',null,['class'=>'form-control','placeholder'=>'Telefono...']) !!}
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

                        {{--<div class="input-field col l6 m6 s12">--}}
                            {{--{!! Form::select('roles', $roles,null, ['id'=>'roles_id','multiple']) !!}--}}
                            {{--{!! Form::label('roles', 'Roles:*') !!}--}}
                        {{--</div>--}}

                    </div>
                        {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                        {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                        <a href="{{ route('admin.users.index') }}" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                            {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                        </a>
                        {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

