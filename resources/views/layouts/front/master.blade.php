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
<a href="#" class="back-to-top waves-effect waves-light btn btn-floating wow slideInUp">Subir</a>
<header>
    @include('layouts.front.nav')
</header>


<main>
    @yield('content')

            <!--Seccion: Contacto-->
    @include('layouts.front.contact')
            <!--Section: Contact-->
</main>

<footer>
{{--FOOTER--}}
@include('layouts.front.footer')
</footer>

        <!--  Scripts-->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
{!! Html::script('landing/js/materialize.js') !!}
{!! Html::script('landing/js/init.js') !!}
{!! Html::script('landing/js/wow.js') !!}
        <!--Google Maps-->
<script src="http://maps.google.com/maps/api/js"></script>




<script>
    //     Inicializar las ani,aciones
    new WOW().init();

    //Inicicio del slider
    $(document).ready(function(){
        $('.slider').slider({full_width: true});


        //           the "href" attribute of .modal-trigger must specify the modal ID that wants to be triggered
        $('#modal-login').modal({
            dismissible: false, // Modal can be dismissed by clicking outside of the modal
            opacity: .5, // Opacity of modal background
            in_duration: 300, // Transition in duration
            out_duration: 200, // Transition out duration
//                       starting_top: '4%', // Starting top style attribute
//                       ending_top: '10%', // Ending top style attribute
//                       ready: function(modal, trigger) { // Callback for Modal open. Modal and trigger parameters available.
//                            alert("Ready");
//                            console.log(modal, trigger);
//                       },
//                       complete: function() { alert('Closed'); } // Callback for Modal close
        });

    });

    // SideNav init
    $(".button-collapse").sideNav();

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
    })

</script>



</body>
</html>
