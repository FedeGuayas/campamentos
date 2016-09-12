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

@include('layouts.header')

{{--<div style="height: 100vh">--}}
    {{--<div class="flex-center">--}}
        {{--<h1 class="animated fadeIn">Material Design for Bootstrap</h1>--}}
    {{--</div>--}}
{{--</div>--}}

<!--Main layout-->
<main>
        <!--container centra el contenido, container-fluid al ancho de la pantalla-->
        <div class="container">
            <!--First row-->
            <div class="row">
                <div class="col-md-7">
                    <!--adicionando efectos a la imagen -->
                    <div class="view overlay hm-white-light z-depth-1-half">
                        <!--img-fluid hace k se ajuste la imagen al tamaño de pantalla -->
                        <img src="http://mdbootstrap.com/images/proffesions/slides/socialmedia/img%20(2).jpg" class="img-fluid " alt="">
                        <div class="mask">
                        </div>
                    </div>
                    <br>
                </div>

                <!--Main information-->
                <div class="col-md-5">
                    {{-- h2-responsive .... el texto del titulo se ajuasta al tamaño de la pantalla del dispositivo--}}
                    <h2 class="h2-responsive">Campamentos Deportivos</h2>
                    <hr>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Blanditiis pariatur quod ipsum atque quam dolorem voluptate officia sunt placeat consectetur alias fugit cum praesentium ratione sint mollitia, perferendis natus quaerat!</p>
                    <a href="" class="btn btn-primary">Entrar!</a>
                </div>
            </div>
            <!--/.First row-->

            <hr class="extra-margins">

            <!--Second row-->
            <div class="row">
                <!--First columnn-->
                <div class="col-md-4">
                    <!--Card-->  <!--los Cards son recuadros para presentar contenido-->
                    <div class="card">

                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(2).jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>
                        <!--/.Card image-->

                        <!--Card content-->
                        <div class="card-block">
                            <!--Title-->
                            <h4 class="card-title">Boxeo</h4>
                            <!--Text-->
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Leer más</a>
                        </div>
                        <!--/.Card content-->

                    </div>
                    <!--/.Card-->
                </div>
                <!--First columnn-->

                <!--Second columnn-->
                <div class="col-md-4">
                    <!--Card-->
                    <div class="card">

                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(4).jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>
                        <!--/.Card image-->

                        <!--Card content-->
                        <div class="card-block">
                            <!--Title-->
                            <h4 class="card-title">Atletismo</h4>
                            <!--Text-->
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Leer más</a>
                        </div>
                        <!--/.Card content-->

                    </div>
                    <!--/.Card-->
                </div>
                <!--Second columnn-->

                <!--Third columnn-->
                <div class="col-md-4">
                    <!--Card-->
                    <div class="card">

                        <!--Card image-->
                        <div class="view overlay hm-white-slight">
                            <img src="http://mdbootstrap.com/images/regular/city/img%20(8).jpg" class="img-fluid" alt="">
                            <a href="#">
                                <div class="mask"></div>
                            </a>
                        </div>
                        <!--/.Card image-->

                        <!--Card content-->
                        <div class="card-block">
                            <!--Title-->
                            <h4 class="card-title">Natación</h4>
                            <!--Text-->
                            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                            <a href="#" class="btn btn-primary">Leer más</a>
                        </div>
                        <!--/.Card content-->

                    </div>
                    <!--/.Card-->
                </div>
                <!--Third columnn-->
            </div>
            <!--/.Second row-->
        </div>
        <!--/.Main layout-->
</main>

    @include('layouts.footer')


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


<script>
    // SideNav init
    $(".button-collapse").sideNav();

    // Custom scrollbar init
    var el = document.querySelector('.custom-scrollbar');
    Ps.initialize(el);
</script>

</body>

</html>