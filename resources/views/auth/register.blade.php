@extends('layouts.front.master-plane')

@section('content')
    <br><br><br>

<div class="container">
    <div class="row">
        <div class="col m8 s12 offset-l1">

            <div class="card hoverable z-depth-5">
                <div class="card-content">
                    <h3 class="card-title teal-text">Registro</h3>

                    {!! Form::open(['url'=>'/register','method'=>'POST','role'=>'form']) !!}
                    <div class="row">
                        <div class="col m5 s12 offset-l1">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <div class="input-field inline">
                                    <i class="material-icons prefix blue-text">face</i>
                                    {!! Form::text('first_name',null,['class'=>'validate', 'value'=>"{{ old('first_name')}}"]) !!}
                                    {!! Form::label('first_name','Nombres') !!}
                                    {{--{!! Form::label('first_name','Nombres',['data-error'=>'wrong', 'data-success'=>'right']) !!}--}}
                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col m6 s12 ">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <div class="input-field">
                                    {!! Form::text('last_name',null,['class'=>'validate', 'value'=>"{{ old('last_name')}}"]) !!}
                                    {!! Form::label('last_name','Apellidos') !!}
                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="row">
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-field inline col m6 s12 offset-l1 ">
                                <i class="material-icons prefix blue-text">mail</i>
                                {!! Form::email('email',null,['class'=>'validate', 'value'=>"{{ old('email')}}"]) !!}
                                {!! Form::label('email','Correo') !!}
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <div class="input-field col m6 s12 offset-l1">
                                <i class="material-icons prefix blue-text">lock_outline</i>
                                {!! Form::password('password',['class'=>'validate']) !!}
                                {!! Form::label('password','Contraseña') !!}
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <div class="input-field col m6 s12 offset-l1">
                                <i class="material-icons prefix blue-text">lock_open</i>
                                {!! Form::password('password_confirmation',['class'=>'validate']) !!}
                                {!! Form::label('password_confirmation','Confirmar contraseña') !!}
                                @if ($errors->has('password_confirmation'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="clearfix">
                        <div class="pull-right">
                           {!! Form::button('Registrarme<i class="material-icons right">create</i>',['class'=>'btn', 'type'=>'submit']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

