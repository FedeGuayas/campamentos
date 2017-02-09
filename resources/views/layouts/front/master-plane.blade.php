<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title','Default') | Campamentos Deportivos</title>

    <!-- CSS  -->

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {!! Html::style('css/font-awesome.min.css') !!}
    {!! Html::style('css/bootstrap.css') !!}
    {!! Html::style('css/bootstrap-social.css') !!}
    {!! Html::style('css/bootstrap-theme.css') !!}
    {!! Html::style('landing/css/style.css') !!}
    {!! Html::style('css/materialize.css') !!}
    {!! Html::style('landing/css/animate.css') !!}

    @yield('style')
</head>
<body>

@yield('body')
{{--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>--}}
        <!--  Scripts-->
{!! Html::script('js/jquery-3.1.0.min.js') !!}
        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}
        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}
        <!-- Materialize core JavaScript -->
{!! Html::script('js/materialize.js') !!}

{{--{!! Html::script('landing/js/materialize.js') !!}--}}
{!! Html::script('js/init.js') !!}
{!! Html::script('js/wow.js') !!}



<script>
    $(document).ready(function(){
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

    {{--//     Inicializar las ani,aciones--}}
            new WOW().init();

    //Inicicio del slider
    $(document).ready(function () {
        $('.slider').slider({full_width: true});
    });

    {{--// SideNav init--}}
     $('.button-collapse').sideNav(
            {
                menuWidth: 240, // Default is 240
                edge: 'left', // Choose the horizontal origin
                closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
            }
    );

</script>


@yield('scripts')

</body>
</html>
