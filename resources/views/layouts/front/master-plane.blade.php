<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <title>@yield('title')</title>

            <!-- CSS  -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('css/bootstrap.min.css') !!}
    {!! Html::style('css/bootstrap-social.css') !!}
    {!! Html::style('landing/css/style.css') !!}
    {!! Html::style('landing/css/materialize.css') !!}

    {!! Html::style('landing/css/animate.css') !!}

</head>
<body>

<header>
    {{--Nav--}}
    {{--@include('layouts.front.nav')--}}
</header>


<main>
    @yield('content')
</main>


<footer>
    {{--FOOTER--}}
{{--@include('layouts.front.footer')--}}
</footer>
        <!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
{!! Html::script('landing/js/materialize.js') !!}
{!! Html::script('landing/js/init.js') !!}
{!! Html::script('landing/js/wow.js') !!}


<script>
    //     Inicializar las ani,aciones
    new WOW().init();

    //Inicicio del slider
    $(document).ready(function(){
        $('.slider').slider({full_width: true});

    });

    // SideNav init
    $(".button-collapse").sideNav();


</script>

@yield('scripts')

</body>
</html>
