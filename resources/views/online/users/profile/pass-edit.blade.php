@extends ('layouts.front.master')
@section('title','Cambiar Contraseña')

@section('content')

    {!! Form::model($user,['route'=>['user.password.update',$user], 'method'=>'PUT','role'=>'form']) !!}
    <div class="col l4 m6 s12 offset-l3">
        @include('alert.success')
        @include('alert.request')

        <div class="input-field s12">
            <i class="fa fa-lock prefix" aria-hidden="true"></i>
            {!! Form::label('password','Contraseña anterior:*') !!}
            {!! Form::password('password',['class'=>'validate']) !!}
        </div>

        <div class="input-field s12">
            <i class="fa fa-unlock-alt prefix" aria-hidden="true"></i>
            {!! Form::label('password_new','Nueva contraseña:*') !!}
            {!! Form::password('password_new',['class'=>'validate']) !!}
        </div>

        <div class="input-field s12">
            <i class="fa fa-key prefix" aria-hidden="true"></i>
            {!! Form::label('password_new','Confirmar contraseña:*') !!}
            {!! Form::password('password_new_confirmation',['class'=>'validate']) !!}
        </div>
    </div>
    <div class="clearfix">
        <div class="center-align">
            {!! Form::button('Guardar<i class="fa fa-save right"  aria-hidden="true"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
            {!! Form::button('Cancelar<i class="fa fa-close right"  aria-hidden="true"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
            <a href="/home">
                {!! Form::button('Regresar<i class="fa fa-arrow-circle-left" aria-hidden="true"></i>',['class'=>'btn waves-effect waves-light blue darken-4']) !!}
            </a>
        </div>
    </div>
    {!! Form::close() !!}


@endsection