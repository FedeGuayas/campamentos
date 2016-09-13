<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Campamentos Deportivos</title>

    <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}
    {{--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">--}}


    <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.min.css') !!}
    {{--<link href="css/bootstrap.min.css" rel="stylesheet">--}}

    <!-- Material Design Bootstrap -->
    {!! Html::style('css/mdb.min.css') !!}
    {{--<link href="css/mdb.min.css" rel="stylesheet">--}}

    <!-- Your custom styles (optional) -->
    {!! Html::style('css/style.css') !!}
    {{--<link href="css/style.css" rel="stylesheet">--}}

</head>

<body >

<!--Navbar-->
<nav class="navbar navbar-dark navbar-fixed-top scrolling-navbar">

    <!-- Collapse button-->
    <button class="navbar-toggler hidden-sm-up" type="button" data-toggle="collapse" data-target="#collapseEx2">
        <i class="fa fa-bars"></i>
    </button>

    <div class="container">

        <!--Collapse content-->
        <div class="collapse navbar-toggleable-xs" id="collapseEx2">
            <!--Navbar Brand-->
            <a class="navbar-brand" href="#">Navbar</a>
            <!--Links-->
            <ul class="nav navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">Quienes somos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#best-features">Mejores servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contactenos</a>
                </li>
            </ul>

            <!--Search form-->
            <form class="form-inline">
                <input class="form-control" type="text" placeholder="Search">
            </form>
        </div>
        <!--/.Collapse content-->

    </div>

</nav>
<!--/.Navbar-->

{{--Imagen a pantalla completa--}}
        <!--Mask-->
{{--view es un contenedor para la imagen de fondo k le permite adicionar mascaras, hm-black-strong oscurece la imagen--}}
<div class="view hm-black-strong">
    <!--Intro content-->
    {{--full-bg-img le da una posicion absoluta a la imagen, flex-center alinea el contenido en el centro de la pantalla--}}
    <div class="full-bg-img flex-center">
        <ul>
            <li>
                {{--h1-responsive adapta el texto a los diferentes pantallas de dispositivos, wow para dar animacion,
                 fadeInDown la animacion seleccionada--}}
                <h1 class="h1-responsive wow fadeInDown" data-wow-delay="0.2s">FDGuayas Campamentos Deportivos</h1></li>
            <li>
                <p class="wow fadeInDown">Su mejor opción</p>
            </li>
            <li>
                <a target="_blank" href="http://mdbootstrap.com/getting-started/" class="btn btn-primary btn-lg wow fadeInLeft" data-wow-delay="0.2s">Entrar!</a>
                <a target="_blank" href="http://mdbootstrap.com/material-design-for-bootstrap/" class="btn btn-default btn-lg wow fadeInRight" data-wow-delay="0.2s">Leer más</a>
            </li>
        </ul>
    </div>
    <!--/Intro content-->
</div>
<!--/.Mask-->


<!-- Main container-->
<div class="container">

    <div class="divider-new">
        <h2 class="h2-responsive wow pulse">Quienes somos</h2>
    </div>

    <!--Section: About-->
    {{--text-xs-center centra el contenido del div horizontalmente--}}
    <section id="about" class="text-xs-center wow rubberBand">

        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit explicabo assumenda eligendi ex exercitationem harum deleniti quaerat beatae ducimus dolor voluptates magnam, reiciendis pariatur culpa tempore quibusdam quidem, saepe eius.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit explicabo assumenda eligendi ex exercitationem harum deleniti quaerat beatae ducimus dolor voluptates magnam, reiciendis pariatur culpa tempore quibusdam quidem, saepe eius.</p>

    </section>
    <!--Section: About-->


    <div class="divider-new">
        <h2 class="h2-responsive wow fadeIn">Mejores servicios</h2>
    </div>


    <!--Section: Best features-->
    <section id="best-features">

        <div class="row">

            <!--First columnn-->
            <div class="col-md-3">
                <!--Card-->
                {{--hoverable adiciona el efecto mouse over al card--}}
                <div class="card hoverable wow slideInUp" data-wow-delay=0.2s">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/regular/city/img%20(2).jpg" class="img-fluid" alt="">
                        <a>
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Boxeo</h4>
                        <hr>
                        <!--Text-->
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident fuga animi architecto dolores dicta cum quo velit.</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
            </div>
            <!--First columnn-->

            <!--Second columnn-->
            <div class="col-md-3">
                <!--Card-->
                <div class="card hoverable wow slideInUp" data-wow-delay="0.4s">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/regular/city/img%20(3).jpg" class="img-fluid" alt="">
                        <a>
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Natación</h4>
                        <hr>
                        <!--Text-->
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident fuga animi architecto dolores dicta cum quo velit.</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
            </div>
            <!--Second columnn-->

            <!--Third columnn-->
            <div class="col-md-3">
                <!--Card-->
                <div class="card hoverable wow slideInUp" data-wow-delay="0.6s">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/regular/city/img%20(4).jpg" class="img-fluid" alt="">
                        <a>
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Football</h4>
                        <hr>
                        <!--Text-->
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident fuga animi architecto dolores dicta cum quo velit.</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
            </div>
            <!--Third columnn-->

            <!--Fourth columnn-->
            <div class="col-md-3">
                <!--Card-->
                <div class="card hoverable wow slideInUp" data-wow-delay="0.8s">

                    <!--Card image-->
                    <div class="view overlay hm-white-slight">
                        <img src="http://mdbootstrap.com/images/regular/city/img%20(8).jpg" class="img-fluid" alt="">
                        <a>
                            <div class="mask"></div>
                        </a>
                    </div>
                    <!--/.Card image-->

                    <!--Card content-->
                    <div class="card-block text-xs-center">
                        <!--Title-->
                        <h4 class="card-title">Ciclismo</h4>
                        <hr>
                        <!--Text-->
                        <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Provident fuga animi architecto dolores dicta cum quo velit.</p>
                    </div>
                    <!--/.Card content-->

                </div>
                <!--/.Card-->
            </div>
            <!--Fourth columnn-->
        </div>

    </section>
    <!--/Section: Best features-->


    <div class="divider-new">
        <h2 class="h2-responsive">Contactenos</h2>
    </div>

    <!--Section: Contact-->
    <section id="contact">
        <div class="row">
            <!--First column-->
            <div class="col-md-8">

                <!--Map container-->
                {{--map-container muestra el mapa y las configuraciones del script,
                z-depth-1 le da una sombra al mapa--}}
                <div id="map-container" class="z-depth-1 wow fadeInUp" style="height: 300px"></div>


            </div>
            <!--/First column-->

            <!--Second column-->
            <div class="col-md-4">

                <ul class="text-xs-center">
                    <li class="wow fadeInUp" data-wow-delay="0.2s"><i class="fa fa-map-marker"></i>
                        <p>Guayaquil, Jose Mascote 1103, Ecuador</p>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.3s"><i class="fa fa-phone"></i>
                        <p>+ 01 234 567 89</p>
                    </li>

                    <li class="wow fadeInUp" data-wow-delay="0.4s"><i class="fa fa-envelope"></i>
                        <p>contact@fedeguayas.com.ec</p>
                    </li>
                </ul>

            </div>
            <!--/Second column-->
        </div>
    </section>
    <!--Section: Contact-->

</div>
<!--/ Main container-->



<!--Footer-->
<footer class="page-footer center-on-small-only mdb-color darken-4">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-3 offset-md-1">
                <h5 class="title">Sobre FDGuayas</h5>
                <p>Material Design (codenamed Quantum Paper) is a design language developed by Google. </p>

                <p>Material Design for Bootstrap (MDB) is a powerful Material Design UI KIT for most popular HTML, CSS, and JS framework - Bootstrap.</p>
            </div>
            <!--/.First column-->

            <hr class="hidden-md-up">

            <!--Second column-->
            <div class="col-md-2 offset-md-1">
                <h5 class="title">First column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Second column-->

            <hr class="hidden-md-up">

            <!--Third column-->
            <div class="col-md-2">
                <h5 class="title">Second column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Third column-->

            <hr class="hidden-md-up">

            <!--Fourth column-->
            <div class="col-md-2">
                <h5 class="title">Third column</h5>
                <ul>
                    <li><a href="#!">Link 1</a></li>
                    <li><a href="#!">Link 2</a></li>
                    <li><a href="#!">Link 3</a></li>
                    <li><a href="#!">Link 4</a></li>
                </ul>
            </div>
            <!--/.Fourth column-->

        </div>
    </div>
    <!--/.Footer Links-->

    <hr>

    <!--Call to action-->
    <div class="call-to-action">
        <h4>Material Design for Bootstrap</h4>
        <ul>
            <li>
                <h5>Get our UI KIT for free</h5></li>
            <li><a target="_blank" href="http://mdbootstrap.com/getting-started/" class="btn btn-danger">Sign up!</a></li>
            <li><a target="_blank" href="http://mdbootstrap.com/material-design-for-bootstrap/" class="btn btn-default">Learn more</a></li>
        </ul>
    </div>
    <!--/.Call to action-->

    <!--Copyright-->
    <div class="footer-copyright">
        <div class="container-fluid">
            © 2016 Copyright: <a href="http://www.fedeguayas.com.ec"> FDGuayas </a>

        </div>
    </div>
    <!--/.Copyright-->

</footer>
<!--/.Footer-->






<!-- SCRIPTS -->

<!-- JQuery -->
{!! Html::script('js/jquery-3.1.0.min.js') !!}
{{--<script type="text/javascript" src="js/jquery-2.2.3.min.js"></script>--}}

<!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}
{{--<script type="text/javascript" src="js/tether.min.js"></script>--}}

<!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}
{{--<script type="text/javascript" src="js/bootstrap.min.js"></script>--}}

<!-- MDB core JavaScript -->
{!! Html::script('js/mdb.min.js') !!}
{{--<script type="text/javascript" src="js/mdb.min.js"></script>--}}


<!--Google Maps-->
<script src="http://maps.google.com/maps/api/js"></script>
<script>
    function init_map() {
        var var_location = new google.maps.LatLng(-2.190048, -79.892138);

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
</script>


<!--Animations initialization-->
<script>
    new WOW().init();
</script>



</body>

</html>