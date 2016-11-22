@extends('layouts.front.master-plane')
@section('title','Reiniciar Clave')
@section('content')
    <br><br><br>
<div class="container">
    <div class="row">
        <div class="col m6 offset-m2">
            <div class="card">
                <div class="card-content">
                    <h3 class="card-title teal-text">Recuperar contraseña</h3>
{{--                    {!! Form::open(['url'=>'/password/reset','method'=>'POST','role'=>'form']) !!}--}}
                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-field col m8 s12 offset-l1">
                                    <i class="material-icons prefix">mail</i>
                                    {{--<input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}">--}}
                                    {!! Form::email('email',$email,['class'=>'validate','id'=>'email','value'=>"{{ old('email')}}"]) !!}
                                    {!! Form::label('email','Correo:') !!}
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
                                <div class="input-field col m8 s12 offset-l1">
                                    <i class="material-icons prefix blue-text">lock_outline</i>
                                    {!! Form::password('password',['class'=>'validate','id'=>'password',]) !!}
                                    {!! Form::label('password','Contraseña:') !!}
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
                                <div class="input-field col m8 s12 offset-l1">
                                    <i class="material-icons prefix blue-text">lock_open</i>
                                    {!! Form::password('password_confirmation',['class'=>'validate','id'=>'password-confirm',]) !!}
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
                                {!! Form::button('Resetear contraseña<i class="fa fa-btn fa-refresh left"></i>',['class'=>'btn', 'type'=>'submit']) !!}
                            </div>
                        </div>
                    {{--{!! Form::close() !!}--}}
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
