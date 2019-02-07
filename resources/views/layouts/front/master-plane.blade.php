<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <meta name="description" content="Campamentos, en estos podrás conocer muchos deportes ( ⛹️‍♀️  🏊  ⚽) y aprender junto a los entrenadores que forman a nuestros campeones de Juegos Nacionales, sudamericanos, bolivarianos, panamericanos y mundiales.">
    <meta name="keywords" content="campamentos deportivos, fedeguayas, vacacionales, ecuelas deportivas, deportes">

    <title>@yield('title','Default') | Campamentos Deportivos</title>

    <link rel="apple-touch-icon" sizes="57x57" href="{{asset('dist/favico/apple-icon-57x57.png')}}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{asset('dist/favico/apple-icon-60x60.png')}}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{asset('dist/favico/apple-icon-72x72.png')}}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{asset('dist/favico/apple-icon-76x76.png')}}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{asset('dist/favico/apple-icon-114x114.png')}}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{asset('dist/favico/apple-icon-120x120.png')}}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{asset('dist/favico/apple-icon-144x144.png')}}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{asset('dist/favico/apple-icon-152x152.png')}}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{asset('dist/favico/apple-icon-180x180.png')}}">
    <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('dist/favico/android-icon-192x192.png')}}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{asset('dist/favico/favicon-32x32.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{asset('dist/favico/favicon-96x96.png')}}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{asset('dist/favico/favicon-16x16.png')}}">
    <link rel="manifest" href="{{asset('dist/favico/manifest.json')}}">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{asset('dist/favico/ms-icon-144x144.png')}}">
    <meta name="theme-color" content="#ffffff">
    <link rel="shortcut icon" href="{{asset('dist/favico/favicon.ico')}}" type="image/x-icon">
    <link rel="icon" href="{{asset('dist/favico/favicon.ico')}}" type="image/x-icon">

    <!-- CSS  -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
    {!! Html::style('css/bootstrap-social.css') !!}
    {!! Html::style('css/bootstrap-theme.css') !!}
    {!! Html::style('landing/css/style.css?ver=2.1') !!}
    {!! Html::style('landing/css/materialize.min.css?ver=2.1') !!}
    {!! Html::style('landing/css/animate.css') !!}
            <!-- Sweet Alert) -->
    {!! Html::style('plugins/sweetalert-master/dist/sweetalert.css') !!}

    <style>
        input[type="search"] {
            height: 64px !important; /* or height of nav */
        }


    </style>

    @yield('style')
</head>
<body>

@yield('body')
        <!--  Scripts-->
{!! Html::script('js/jquery-3.1.0.min.js') !!}
        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}
        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}
{!! Html::script('landing/js/materialize.min.js?ver=2.1') !!}
{!! Html::script('js/init.js') !!}
{!! Html::script('js/wow.js') !!}

        <!-- Sweet alert -->
{!! Html::script('plugins/sweetalert-master/dist/sweetalert.min.js') !!}


<script>

    $(document).ready(function(){

        $('select').material_select({}); //inicializar el select de materialize

//        Boton dropdown
         $(".dropdown-button").dropdown({

         });

        {{--// SideNav init--}}
        $('.button-collapse').sideNav(
                {
                    menuWidth: 240, // Default is 240
                    edge: 'left', // Choose the horizontal origin
                    closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
                }
        );

        var $backToTop = $(".back-to-top");
        $backToTop.hide();

        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) { /* back to top will appear after the user scrolls 100 pixels */
                $backToTop.fadeIn();
            } else {
                $backToTop.fadeOut();
            }
        });

        $backToTop.on('click', function(e) {
            $("html, body").animate({scrollTop: 0}, 500);

        });
    });

    {{--//     Inicializar las animaciones--}}
            new WOW().init();



    //Inicicio del slider
    $(document).ready(function () {
        $('.slider').slider();
    });

</script>


@yield('scripts')

<!-- BEGIN JIVOSITE CODE {literal} -->
<script type='text/javascript'>
    (function(){ var widget_id = 'zJUR8BXmo4';var d=document;var w=window;function l(){var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true;s.src = '//code.jivosite.com/script/widget/'+widget_id; var ss = document.getElementsByTagName('script')[0]; ss.parentNode.insertBefore(s, ss);}if(d.readyState=='complete'){l();}else{if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}})();
</script>
<!-- {/literal} END JIVOSITE CODE -->

</body>
</html>
