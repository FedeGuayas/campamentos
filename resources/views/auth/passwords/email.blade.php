@extends('layouts.front.master-plane')
@section('title','Recuperar Clave')
@section('style')
    <style>
        body {
            background: linear-gradient(to bottom, indigo , teal);"
        }
    </style>
@endsection
@section('body')
    <br><br><br>
<div class="container">
    <div class="row">
        <div class="col s12 m8 offset-m2 ">
            <div class="card hoverable z-depth-5">
                {!! Form::open(['url'=>'/password/email','method'=>'POST','role'=>'form']) !!}
                <div class="card-content">
                    <span class="card-title">Recuperar Contraseña</span>
                    <div class="row">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>
                    <div class="row">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-field col s12 m10 offset-m1">
                                <i class="material-icons prefix cyan-text">mail</i>
                                {!! Form::email('email',null,['class'=>'validate', 'id'=>'email', 'value'=>"{{ old('email')}}"]) !!}
                                {!! Form::label('email','Correo:') !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-action center-align ">
                    {!! Form::button(' Recuperar contraseña', ['class'=>'btn','type' => 'submit']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@endsection
