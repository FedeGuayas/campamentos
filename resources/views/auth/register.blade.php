@extends('layouts.front.master-plane')
@section('title','Registrarse')
@section('body')
    <br><br><br>
<div class="container">
    <div class="row">
        <div class="col s12 m8 l8 offset-l2 offset-m1">

            <div class="card-panel hoverable z-depth-4 wow flipInX">
                <div class="card-content">
                    <div class="row">
                        <h3 class="card-title flow-text indigo-text">Registro</h3>
                        <a href="{{url('/')}}"
                           class="btn-floating waves-effect waves-light red right tooltipped"
                           data-position="left" data-tooltip="Inicio"><i class="fa fa-home"></i>
                        </a>
                    </div>

                    {!! Form::open(['url'=>'/register','method'=>'POST','role'=>'form']) !!}
                    <div class="row">
                        <div class="col s12 l6">
                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                <div class="input-field ">
                                    <i class="material-icons prefix blue-text">face</i>
                                    {!! Form::text('first_name',null,['class'=>'validate', 'value'=>"{{ old('first_name')}}",'style'=>'text-transform:uppercase']) !!}
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
                        <div class="col s12 l6">
                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                <div class="input-field">
                                    {!! Form::text('last_name',null,['class'=>'validate', 'value'=>"{{ old('last_name')}}",'style'=>'text-transform:uppercase']) !!}
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
                            <div class="input-field ">
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
                            <div class="input-field">
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
                            <div class="input-field">
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
                           {!! Form::button('Registrarme<i class="material-icons right">create</i>',['class'=>'btn blue darken-4', 'type'=>'submit']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

