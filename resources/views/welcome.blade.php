@extends('layouts.front.master')

@section('title','Campamentos Deportivos')
@section('content')

    {{--Banner imagen Parallax--}}
    <div id="index-banner" class="parallax-container banner-content flex-center">
        <div class="section no-pad-bot">
            <div class="container flow-text">

                <h2 class="header center teal-text text-lighten-2 wow fadeInDown">                              Campamentos Deportivos</h2>

                <div class="row center">
                    <h5 class="header col s12 light wow fadeIn" data-wow-delay="1s">La mejor opción para ejercitar y disfrutar en familia.</h5>
                </div>
               @if (Auth::guest())
                <div class="row center">
                    <a href="{{url('/login')}}" class="waves-effect waves-light btn btn-large teal lighten-1 wow flipInX" data-wow-delay="1.5s"><i class="material-icons right">input</i>Entrar</a>
                    <a href="{{ url('/register') }}" class="waves-effect waves-light btn btn-large teal lighten-1 wow flipInX" data-wow-delay="1.5s"><i class="material-icons right">fingerprint</i>Registrarse</a>
                </div>
                @endif
            </div>
        </div>
        <div class="parallax"><img src="{{asset('img/camp/the-ball-cancha.jpg')}}" style=" opacity: 100; " alt="Unsplashed background img 1"></div>
    </div>

    {{--Seccion de las disciplinas--}}
    <div class="container">
        <div class="section"  id="disciplinas">
            <div class="section-title">
                <div class="divider-new wow bounce">
                    <h2 class="h2-responsive wow fadeInDown">Disciplinas</h2>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m4">
                    <div class="card hoverable z-depth-4 sticky-action medium wow fadeInUp" data-wow-delay="0.3s">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="img/camp/rana1-deporte-min.jpg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">Disciplina #1<i class="material-icons right">more_vert</i></span>
                            <p><a href="#">Entrar</a> para inscribirme</p>
                            <p><a href="#">Contactar</a></p>
                        </div>
                        <div class="card-action">
                            <div class="clearfix">
                                <div class="pull-left price teal-text">$15.00</div>
                                <a class="waves-effect waves-light btn pull-right">Pagar</a>
                            </div>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">Disciplina #1<i class="material-icons right">close</i></span>
                            <p>Una pequeña descripción donde se describa esta disciplina</p>
                        </div>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="card hoverable z-depth-4 sticky-action medium wow fadeInUp" data-wow-delay="0.6s">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="img/camp/rana2-deporte-min.jpg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">Disciplina #2<i class="material-icons right">more_vert</i></span>
                            <p><a href="#">Entrar</a> para inscribirme</p>
                            <p><a href="#">Contactar</a></p>
                        </div>
                        <div class="card-action">
                            <div class="clearfix">
                                <div class="pull-left price teal-text">$15.00</div>
                                <a class="waves-effect waves-light btn pull-right">Pagar</a>
                            </div>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">Disciplina #2<i class="material-icons right">close</i></span>
                            <p>Una pequeña descripción donde se describa esta disciplina</p>
                        </div>
                    </div>
                </div>

                <div class="col s12 m4">
                    <div class="card hoverable z-depth-4 sticky-action medium wow fadeInUp" data-wow-delay="0.9s">
                        <div class="card-image waves-effect waves-block waves-light">
                            <img class="activator" src="img/camp/gimnasia-min.jpg">
                        </div>
                        <div class="card-content">
                            <span class="card-title activator grey-text text-darken-4">Disciplina #3<i class="material-icons right">more_vert</i></span>
                            <p><a href="#">Entrar</a> para inscribirme</p>
                            <p><a href="#">Contactar</a></p>
                        </div>
                        <div class="card-action">
                            <div class="clearfix">
                                <div class="pull-left price teal-text">$15.00</div>
                                <a class="waves-effect waves-light btn pull-right">Pagar</a>
                            </div>
                        </div>
                        <div class="card-reveal">
                            <span class="card-title grey-text text-darken-4">Disciplina #3<i class="material-icons right">close</i></span>
                            <p>Una pequeña descripción donde se describa esta disciplina</p>
                        </div>
                    </div>
                </div>
            </div>

            {{--<!--   Icon Section   -->--}}
            {{--<div class="row">--}}
            {{--<div class="col s12 m4">--}}
            {{--<div class="icon-block">--}}
            {{--<h2 class="center brown-text"><i class="material-icons">flash_on</i></h2>--}}
            {{--<h5 class="center">Speeds up development</h5>--}}

            {{--<p class="light">We did most of the heavy lifting for you to provide a default stylings that incorporate our custom components. Additionally, we refined animations and transitions to provide a smoother experience for developers.</p>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col s12 m4">--}}
            {{--<div class="icon-block">--}}
            {{--<h2 class="center brown-text"><i class="material-icons">group</i></h2>--}}
            {{--<h5 class="center">User Experience Focused</h5>--}}

            {{--<p class="light">By utilizing elements and principles of Material Design, we were able to create a framework that incorporates components and animations that provide more feedback to users. Additionally, a single underlying responsive system across all platforms allow for a more unified user experience.</p>--}}
            {{--</div>--}}
            {{--</div>--}}

            {{--<div class="col s12 m4">--}}
            {{--<div class="icon-block">--}}
            {{--<h2 class="center brown-text"><i class="material-icons">settings</i></h2>--}}
            {{--<h5 class="center">Easy to work with</h5>--}}

            {{--<p class="light">We have provided detailed documentation as well as specific code examples to help new users get started. We are also always open to feedback and can answer any questions a user may have about Materialize.</p>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}

        </div>
    </div>



    {{--Imagen Parllax--}}
    <div class="parallax-container valign-wrapper">
        <div class="section no-pad-bot">
            <div class="container">
                <div class="row center">
                    <h5 class="header col s12 light">Nuestras canchas son de primer nivel</h5>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{asset('img/camp/the-ball-cancha.jpg')}}" alt="Unsplashed background img 2"></div>
    </div>

    {{--Seccion de los Beneficios--}}
    <div class="container">
        <div class="section"  id="beneficios">
            <div class="section-title">
                <div class="divider-new wow bounce" data-wow-duration="0.5s">
                    <h2 class="h2-responsive wow fadeInDown">Beneficios</h2>
                </div>
            </div>

            <div class="slider">
                <ul class="slides">
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/1"> <!-- random image -->
                        <div class="caption center-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun  slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/2"> <!-- random image -->
                        <div class="caption left-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun  slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/3"> <!-- random image -->
                        <div class="caption right-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun  slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/4"> <!-- random image -->
                        <div class="caption center-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun  slogan.</h5>
                        </div>
                    </li>
                </ul>
            </div>

        </div>
    </div>



    <div class="parallax-container valign-wrapper">
        <div class="section no-pad-bot">
            <div class="container">
                <div class="row center">
                    <h5 class="header col s12 light">Todo lo que te propongas lo podras lograr</h5>
                </div>
            </div>
        </div>
        <div class="parallax"><img src="{{asset('img/camp/nadador-min.jpg')}}" alt="Unsplashed background img 3"></div>
    </div>


@endsection