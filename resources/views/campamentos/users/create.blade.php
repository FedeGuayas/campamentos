@extends('layouts.admin.index')

@section('title', 'Crear Usuario')

@section('content')

    <div class="row">
        <div class="col s8">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Usuario</h5>
                <div class="card-content ">

                    {!! Form::open(['route'=>'admin.users.store', 'method'=>'POST'])  !!}
                    <div class="col l12 m8 s12">

                        <div class="input-field col l6 m4 s12 ">
                            <i class="material-icons prefix">account_circle</i>
                            {!! Form::label('first_name','Nombres:*') !!}
                            {!! Form::text('first_name',null,['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col l6 m4 s12">
                            {!! Form::label('last_name','Apellidos:*') !!}
                            {!! Form::text('last_name',null,['class'=>'validate']) !!}
                        </div>

                    </div>


                    <div class="col l12 m8 s12">

                        <div class="input-field col l6 m4 s12">
                            <i class="material-icons prefix">email</i>
                            {!! Form::label('email','Correo:*') !!}
                            {!! Form::email('email',null,['class'=>'validate', 'placeholder'=>'correo@gmail.com']) !!}
                        </div>

                        <div class="input-field col l6 m4 s12">
                            {!! Form::label('password','Contraseña:*') !!}
                            {!! Form::password('password',['class'=>'validate']) !!}
                        </div>

                        <div class="input-field col l4 m4 s12">
                            {!! Form::select('roles', ['L' => 'Large', 'S' => 'Small'],null, ['placeholder' => 'Seleccione roles...','multiple']) !!}
                            {!! Form::label('roles', 'Roles:*') !!}
                        </div>

                    </div>
                        {!! Form::button('Crear<i class="material-icons right">send</i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                        {!! Form::button('Canselar<i class="material-icons right">cancel</i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                        {!! Form::close() !!}

                </div><!--/.card content-->
            </div><!--/.card panel-->
        </div><!--/.col s12-->
    </div><!--/.row-->

        <script>

            $(document).ready(function () {
                $('select').material_select();
            });

        </script>

@endsection

