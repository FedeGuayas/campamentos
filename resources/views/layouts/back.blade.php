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

<body class="fixed-sn blue-skin">

<!--Double navigation-->
<header>

    <!-- Sidebar navigation -->
    <ul id="slide-out" class="side-nav fixed custom-scrollbar dark-gradient">

        <!-- Logo -->
        <li>
            <div class="logo-wrapper waves-light">
                <a href="#"><img src="http://mdbootstrap.com/wp-content/uploads/2015/12/mdb-white2.png" class="img-fluid flex-center"></a>
            </div>
        </li>
        <!--/. Logo -->

        <!--Social-->
        <li>
            <ul class="social">
                <li><a class="icons-sm fb-ic"><i class="fa fa-facebook"> </i></a></li>
                <li><a class="icons-sm pin-ic"><i class="fa fa-pinterest"> </i></a></li>
                <li><a class="icons-sm gplus-ic"><i class="fa fa-google-plus"> </i></a></li>
                <li><a class="icons-sm tw-ic"><i class="fa fa-twitter"> </i></a></li>
            </ul>
        </li>
        <!--/Social-->

        <!--Search Form-->
        <li>
            <form class="search-form" role="search">
                <div class="form-group waves-light">
                    <input type="text" class="form-control" placeholder="Search">
                </div>
            </form>
        </li>
        <!--/.Search Form-->

        <!-- Side navigation links -->
        <li>
            <ul class="collapsible collapsible-accordion">
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-chevron-right"></i> Submit blog<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#" class="waves-effect">Submit listing</a>
                            </li>
                            <li><a href="#" class="waves-effect">Registration form</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-hand-pointer-o"></i> Instruction<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#" class="waves-effect">For bloggers</a>
                            </li>
                            <li><a href="#" class="waves-effect">For authors</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-eye"></i> About<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#" class="waves-effect">Introduction</a>
                            </li>
                            <li><a href="#" class="waves-effect">Monthly meetings</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-envelope-o"></i> Contact me<i class="fa fa-angle-down rotate-icon"></i></a>
                    <div class="collapsible-body">
                        <ul>
                            <li><a href="#" class="waves-effect">FAQ</a>
                            </li>
                            <li><a href="#" class="waves-effect">Write a message</a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </li>
        <!--/. Side navigation links -->

    </ul>
    <!--/. Sidebar navigation -->


    <!--Navbar-->
    <nav class="navbar navbar-fixed-top scrolling-navbar double-nav">

        <!-- SideNav slide-out button -->
        {{--<div class="pull-left">--}}
            {{--<a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>--}}
        {{--</div>--}}

        <!-- Breadcrumb-->
        <div class="breadcrumb-dn">
            <p>Breadcrumb or page title</p>
        </div>

        <ul class="nav navbar-nav pull-right">

            <li class="nav-item ">
                <a class="nav-link"><i class="fa fa-envelope"></i> <span class="hidden-sm-down">Contact</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link"><i class="fa fa-comments-o"></i> <span class="hidden-sm-down">Support</span></a>
            </li>
            <li class="nav-item ">
                <a class="nav-link"><i class="fa fa-user"></i> <span class="hidden-sm-down">Account</span></a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i> Profile</a>
                <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>

    </nav>
    <!--/.Navbar-->

</header>
<!--/Double navigation-->


<!--Main layout-->
<main>
    <div class="main-wrapper">
        <div class="container-fluid">
            <div class="row">

                <div class="col-md-8">
                    <h2>Your content</h2>
                </div>

            </div>
        </div>
    </div>
</main>
<!--/Main layout-->


<!--Footer-->
<footer class="page-footer center-on-small-only mdb-color darken-4">

    <!--Footer Links-->
    <div class="container-fluid">
        <div class="row">

            <!--First column-->
            <div class="col-md-3 offset-md-1">
                <h5 class="title">Sobre FDGuayas</h5>
                <p>La <strong>FEDERACIÓN DEPORTIVA DEL GUAYAS</strong> es una institución privada y autónoma. Es la
                    matriz de nuestra provincia en la formación deportiva amateur, ya que lidera, administra, fomenta y
                    desarrolla el deporte para mejorar la calidad de vida de la comunidad. </p>


            </div>
            <!--/.First column-->

            <hr class="hidden-md-up">

            <!--Second column-->
            <div class="col-md-2 offset-md-1">
                <h5 class="title">Primeros links</h5>
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
                <h5 class="title">Segundos link</h5>
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
                <h5 class="title">Terceros link</h5>
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
        <h4>FDGuayas --- La nueva era</h4>
        <ul>
            <li>
                <h5>Entre e inscribase en nuestros campamentos</h5></li>
            <li><a target="_blank" href="http://mdbootstrap.com/getting-started/" class="btn btn-danger">Entrar!</a>
            </li>
            <li><a target="_blank" href="http://mdbootstrap.com/material-design-for-bootstrap/" class="btn btn-default">Leer
                    mas</a></li>
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

        <!-- Materialize core JavaScript for sideNav -->
{!! Html::script('js/materialize.min.js') !!}
{{--<script type="text/javascript" src="js/mdb.min.js"></script>--}}



<script>
    // SideNav Init
    $(".button-collapse").sideNav();


    // Custom scrollbar init
    var el = document.querySelector('.custom-scrollbar');
    Ps.initialize(el);
</script>



</body>

</html>