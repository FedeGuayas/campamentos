@extends('layouts.admin.index')

@section('title', 'Crear Usuario')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Usuario</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.users.store', 'method'=>'POST'])  !!}
                    <div class="col s12">

                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user-plus prefix"></i>
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

                        {{--<div class="input-field col l6 m6 s12">--}}
                            {{--{!! Form::select('roles[]', $roles,null, ['id'=>'roles_id','multiple']) !!}--}}
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

