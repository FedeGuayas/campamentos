
    <div class="card wow fadeInRight">
        <div class="card-block">
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

            <div class="text-xs-center">
                <h3><i class="fa fa-user"></i> Registrarse con:</h3>
                <a href="" class="btn btn-floating btn-social-icon btn-facebook"><i class="fa fa-facebook"></i></a>
                <a href="" class="btn btn-floating btn-social-icon btn-twitter"><i class="fa fa-twitter"></i></a>
                <a href="" class="btn btn-floating btn-social-icon btn-google"><i class="fa fa-google-plus"></i></a>
                <hr>
                <h3>o:</h3>
            </div> <!--/. Header-->

            <!--Body-->
            {!! Form::open(['url'=>'/login','method'=>'POST','role'=>'form']) !!}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <div class="md-form">
                    <i class="fa fa-envelope prefix"></i>
                    {!! Form::email('email',null,['class'=>'form-control', 'id'=>'email', 'value'=>"{{ old('email')}}"]) !!}
                    {!! Form::label('email','Correo:') !!}
                    @if ($errors->has('email'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <div class="md-form">
                    <i class="fa fa-lock prefix"></i>
                    {!! Form::password('password',['class'=>'form-control', 'id'=>'password']) !!}
                    {!! Form::label('password','Contraseña:') !!}
                    @if ($errors->has('password'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="text-xs-center">

                {!! Form::button('Entrar<i class="fa fa-sign-in left"></i>', ['class'=>'btn btn-ptc btn-lg','type' => 'submit']) !!}
                {{--<button class="btn btn-ptc btn-lg">Entrar</button>--}}
                <hr>
                <fieldset class="form-group">
                    {!! Form::checkbox('remember',null,false,['id'=>'remember']) !!}
                    {!! Form::label('remember','Recordarme') !!}
                </fieldset>
            </div>
            {!! Form::close() !!}
            <a  class="fa fa-external-link-square" href="{{ url('/password/reset') }}">Olvido su contraseña?</a>
            <a  class="fa fa-external-link-square" href="{{ url('/register') }}">Registrarme</a>

        </div>
    </div>


