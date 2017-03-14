@extends('layouts.front.master-plane')

@section('title','Bienvenidos')

@section('body')
    @include('layouts.front.navWelcome')

    <a href="#" class="back-to-top waves-effect waves-light btn btn-floating animated slideInUp">Subir</a>


    {{--Banner imagen Parallax--}}
    <div id="index-banner" class="parallax-container banner-content flex-center">
        <div class="section no-pad-bot">
            <div class="container flow-text">

                <h2 class="header center teal-text text-lighten-2 animated fadeInDown">Campamentos Deportivos</h2>

                <div class="row center">
                    <h5 class="header col s12 light wow fadeIn" data-wow-delay="0.5s">La mejor opción para ejercitar y
                        disfrutar en familia.</h5>
                </div>

                @if (Auth::guest())
                    <div class="row center">
                        <a href="{{url('/login')}}"
                           class="waves-effect waves-light btn btn-large teal lighten-1 animated flipInX"
                           data-wow-delay="1.5s"><i class="material-icons right">input</i>Entrar</a>
                        <a href="{{ url('/register') }}"
                           class="waves-effect waves-light btn btn-large teal lighten-1 animated flipInX"
                           data-wow-delay="1.5s"><i class="material-icons right">fingerprint</i>Registrarse</a>
                    </div>
                @endif
            </div>
        </div>
        <div class="parallax"><img src="{{asset('img/camp/the-ball-cancha.jpg')}}" style=" opacity: 100; "
                                   alt="Unsplashed background img 1"></div>
    </div>

    {{--Seccion de las disciplinas--}}
    <div class="container">
        <div class="section" id="disciplinas">
            <div class="section-title">
                <div class="divider-new wow bounce">
                    <h2 class="h2-responsive wow fadeInDown">Disciplinas</h2>
                </div>
            </div>



            <div class="row">

                {{--<div class="carousel-fixed-item center">--}}
                <div class="control-center-up center-align">
                    <a class="btn-floating waves-effect blue-grey waves-purple" href="#myCarousel"
                       data-slide="prev"><i class="fa fa-chevron-left"></i><span class="sr-only">Anterior</span></a>
                    <a class="btn-floating waves-effect blue-grey waves-purple"  href="#myCarousel"
                       data-slide="next"><i class="fa fa-chevron-right"></i><span class="sr-only">Siguiente</span></a>
                </div>
                {{--</div>--}}

                        <!-- Left and right controls -->
                {{--<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">--}}
                    {{--<span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>--}}
                    {{--<span class="sr-only">Previous</span>--}}
                {{--</a>--}}
                {{--<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">--}}
                    {{--<span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>--}}
                    {{--<span class="sr-only">Next</span>--}}
                {{--</a>--}}
{{--             @foreach($cursos->chunk(3) as $cursosChunck)--}}
                @foreach($cursos as $curso)
                    @if($curso->program->imagen && ($curso->cupos - $curso->contador) >=1)
                        <div class="col s4 m4">
                            <div class="card hoverable z-depth-4 sticky-action  wow fadeInUp"
                                 data-wow-delay="0.3s">
                                <div class="card-image waves-effect waves-block waves-light">
                                    <img class="activator"
                                         src="{{ asset('/img/camp/disciplinas/'.$curso->program->imagen)}}">
                                </div>
                                <div class="card-content">
                                    <span class="card-title activator grey-text text-darken-4">{{$curso->program->disciplina->disciplina}}
                                        <i class="material-icons right">more_vert</i></span>
                                    <p style="font-size: 10px;">{{$curso->dia->dia}} / {{$curso->horario->start_time.' - '.$curso->horario->end_time}} / {{ $curso->init_age.'-'.$curso->end_age}} años</p>
                                </div>
                                <div class="card-action">
                                    <div class="clearfix">
                                        <div class="pull-left price teal-text">
                                            $ {{number_format($curso->mensualidad,2,'.',' ')}}</div>
                                        @if (Auth::guest())
                                            <a href="{{url('/login')}}"
                                               class="waves-effect waves-light btn pull-right">Entrar</a>
                                        @else
                                            <a class="waves-effect waves-light btn pull-right">Pagar</a>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-reveal">
                                    <span class="card-title grey-text text-darken-4">{{$curso->program->disciplina->disciplina}}
                                        <i class="material-icons right">close</i></span>
                                    <table class="table highlight responsive-table" cellspacing="0" width="100%" style="width: 100%">
                                        <tr>
                                            <th>Escenario</th>
                                            <td>{{$curso->program->escenario->escenario}}</td>
                                        </tr>
                                        <tr>
                                            <th>Mes</th>
                                            <td>{{$curso->program->modulo->modulo}}</td>
                                        </tr>
                                        <tr>
                                            <th>Matrícula</th>
                                            <td> $ {{number_format($curso->program->matricula,2,'.',' ')}}</td>
                                        </tr>
                                        <tr>
                                            <th>Disponibilidad</th>
                                            <td>
                                                @if( ($curso->cupos - $curso->contador) <=1)
                                                    <span class="label label-danger">{{ $curso->cupos - $curso->contador }}</span>
                                                @else
                                                    <span class="label label-success">{{ $curso->cupos - $curso->contador }}</span>
                                                @endif</td>
                                        </tr>
                                        <tr>
                                            <th>Dias</th>
                                            <td>{{$curso->dia->dia}}</td>
                                        </tr>
                                        <tr>
                                            <th>Horarios</th>
                                            <td>{{$curso->horario->start_time.' - '.$curso->horario->end_time}}</td>
                                        </tr>
                                        <tr>
                                            <th>Edades</th>
                                            <td>{{ $curso->init_age.'-'.$curso->end_age}} años</td>
                                        </tr>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                    {{--@endforeach--}}


                {{--</div>--}}

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
        <div class="parallax"><img src="{{asset('img/camp/the-ball-cancha.jpg')}}"
                                   alt="Unsplashed background img 2"></div>
    </div>

    {{--Seccion de los Beneficios--}}
    <div class="container">
        <div class="section" id="beneficios">
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
                            <h5 class="light grey-text text-lighten-3">Poner aki algun slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/2"> <!-- random image -->
                        <div class="caption left-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/3"> <!-- random image -->
                        <div class="caption right-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun slogan.</h5>
                        </div>
                    </li>
                    <li>
                        <img src="http://lorempixel.com/580/250/nature/4"> <!-- random image -->
                        <div class="caption center-align">
                            <h3>Texto llamativo!</h3>
                            <h5 class="light grey-text text-lighten-3">Poner aki algun slogan.</h5>
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
        <div class="parallax"><img src="{{asset('img/camp/nadador-min.jpg')}}" alt="Unsplashed background img 3">
        </div>
    </div>

    @include('layouts.front.contact')



    @include('layouts.front.footer')
@endsection

@section('scripts')
    <script src="http://maps.google.com/maps/api/js"></script>
    <script>

        function init_map() {
            var var_location = new google.maps.LatLng(-2.190098, -79.892341);
            var var_mapoptions = {
                center: var_location,
                zoom: 14
            };
            var var_marker = new google.maps.Marker({
                position: var_location,
                map: var_map,
                title: "FDGuayas"
            });
            var var_map = new google.maps.Map(document.getElementById("map-container"),
                    var_mapoptions);
            var_marker.setMap(var_map);
        }
        google.maps.event.addDomListener(window, 'load', init_map);

        $(document).ready(function () {

            var primera1 = localStorage.getItem('primera1');
            if (primera1 == null) {
                localStorage.setItem('primera1', 1);
                // popup aki
                setTimeout(function () {
                    swal({
                        title: "Bienvenido!",
                        text: "Para un mejor desempeño en nuestro sitio debe utilizar Google Chrome Versión 56.0.2924.87 o superior...",
                        type: "info",
                    })
                }, 500);
            }
        });



        $('.carousel.carousel-slider').carousel({fullWidth: false});






    </script>

@endsection
