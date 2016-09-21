@extends('layouts.admin.index')

@section('title', 'Crear Usuario')

@section('content')

    {!! Form::open(['route'=>'admin.users.store', 'method'=>'POST'])  !!}
<div class="row">
    <div class="input-field col l4 m4 s12 ">
        {!! Form::label('first_name','Nombres:*') !!}
        {!! Form::text('first_name',null,['class'=>'validate']) !!}
    </div>
    <div class="input-field col l4 m4 s12">
        {!! Form::label('last_name','Apellidos:*') !!}
        {!! Form::text('last_name',null,['class'=>'validate']) !!}
    </div>
</div>

    <div class="input-field col l2 m4 s12">
        {!! Form::label('email','Correo:*') !!}
        {!! Form::email('email',null,['class'=>'validate', 'placeholder'=>'correo@gmail.com']) !!}
    </div>

    <div class="input-field col l4 m4 s12">
        {!! Form::label('password','Contraseña:*') !!}
        {!! Form::password('password',['class'=>'validate']) !!}
    </div>

    {!! Form::submit('Enviar',['class'=>'btn waves-effect waves-light']) !!}
    <button class="btn waves-effect waves-light" type="submit">Submit
        <i class="material-icons right">send</i>
    </button>


    {!! Form::close() !!}

@endsection

