@extends('layouts.front.master-plane')
@section('title','Recuperar Clave')
@section('content')
    <br><br><br>
<div class="container">
    <div class="row">
        <div class="col m6 offset-m2">
            <div class="card card-panel  teal lighten-2 hoverable z-depth-4">
                <div class="card-content">
                    <h3 class="card-title white-text">Recuperar Contraseña</h3>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    {!! Form::open(['url'=>'/password/email','method'=>'POST','role'=>'form']) !!}
                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <div class="input-field col m10 s12 white-text offset-l1">
                                <i class="material-icons white-text prefix">mail</i>
                                {!! Form::email('email',null,['class'=>'validate', 'id'=>'email', 'value'=>"{{ old('email')}}"]) !!}
                                {!! Form::label('email','Correo:') !!}
                                @if ($errors->has('email'))
                                    <span class="help-block white-text">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                    <div class="clearfix">
                        <div class="input-field pull-right">
                            {!! Form::button('Recuperar contraseña <i class="fa fa fa-send left"></i>', ['class'=>'btn ','type' => 'submit']) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
