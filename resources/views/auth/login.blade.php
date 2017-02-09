@extends('layouts.front.master-plane')
@section('title','Login')
@section('body')
    <br><br><br>
    <div class="container">
        <div class="row">
            <div class="col s12 m6 offset-l2">


                <div class="card">

                    <div class="card-content">
                        <h3 class="card-title teal-text">Login</h3>
                        <!--Header-->
                        {{-- Mensaje de activacion por email--}}
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                        {!! Form::open(['url'=>'/login','method'=>'POST','role'=>'form']) !!}
                        <div class="row">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="input-field col l10 m6 s12 offset-l1">
                                    <i class="material-icons prefix blue-text">mail</i>
                                    {!! Form::email('email',null,['class'=>'validate form-control', 'id'=>'email', 'value'=>"{{ old('email')}}"]) !!}
                                    {!! Form::label('email','Correo:') !!}
                                    @if ($errors->has('email'))
                                        <span class="text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="input-field col l10 m6 s12 offset-l1">
                                    <i class="material-icons prefix blue-text">lock_outline</i>
                                    {!! Form::password('password',['class'=>'validate form-control', 'id'=>'password']) !!}
                                    {!! Form::label('password','Contraseña:') !!}
                                    @if ($errors->has('password'))
                                        <span class="text-danger"><strong>{{ $errors->first('password') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="input-field center">
                            {!! Form::checkbox('remember',null,false,['id'=>'remember', 'class'=>'filled-in']) !!}
                            {!! Form::label('remember','Recordarme') !!}
                        </div>
                        <div class="clearfix">
                            <div class="input-field pull-right">
                                {!! Form::button('Entrar<i class="fa fa-sign-in left"></i>', ['class'=>'btn ','type' => 'submit']) !!}

                            </div>
                        </div>

                        {!! Form::close() !!}
                    </div>

                    <div class="card-action">

                        <a  class="fa fa-external-link-square blue-text pull-left" href="{{ url('/password/reset') }}"> Olvido su contraseña?</a>
                        <a  class="fa fa-external-link-square blue-text pull-right" href="{{ url('/register') }}"> Registrarme</a>

                    </div>


                </div>

            </div>
        </div>
    </div>

@endsection




























        {{--<div class="card">--}}
            {{--<div class="card">--}}


                    {{--<div class="text-xs-center">--}}
                    {{--<h3><i class="fa fa-user"></i> Registrarse con:</h3>--}}
                    {{--<a href="" class="btn btn-floating btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>--}}
                    {{--<a href="" class="btn btn-floating btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>--}}
                    {{--<a href="" class="btn btn-floating btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>--}}
                    {{--<hr>--}}
                    {{--<h3>o:</h3>--}}
                    {{--</div> <!--/. Header-->--}}

                            {{--<!--Body-->--}}




                    {{--<div class="text-xs-center">--}}


                        {{--<button class="btn btn-ptc btn-lg">Entrar</button>--}}
                        {{--<hr>--}}

                    {{--</div>--}}




            {{--</div>--}}
        {{--</div>--}}

