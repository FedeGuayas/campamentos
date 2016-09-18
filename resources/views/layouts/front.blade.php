<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>Campamentos Deportivos</title>

    <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}

            <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.css') !!}

            <!-- Bootstrap social core CSS -->
    {!! Html::style('css/bootstrap-social.css') !!}

            <!-- Material Design Bootstrap -->
    {!! Html::style('css/mdb.css') !!}

            <!-- Material Design Bootstrap -->
{{--        {!! Html::style('css/materialize.css') !!}--}}

            <!-- Your custom styles (optional) -->
{{--    {!! Html::style('css/style.css') !!}--}}


</head>

<body class="fixed-sn blue-skin">

<!--Navbar-->
@include('layouts.front.navbar')
        <!--/.Navbar-->

<!--Mask-->
@include('layouts.front.mask')
        <!--/.Mask-->

<!--Main container-->
@include('layouts.front.main')
        <!--/Main container-->

<!--Footer-->
@include('layouts.front.footer')
        <!--/.Footer-->

<!-- SCRIPTS -->

<!-- JQuery -->
{!! Html::script('js/jquery-3.1.0.min.js') !!}

        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}

        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}

        <!-- MDB core JavaScript -->
{!! Html::script('js/mdb.min.js') !!}

        <!-- Materialize core JavaScript -->
{!! Html::script('js/materialize.js') !!}

        <!--Google Maps-->
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

</script>

<!-- Animations init-->
<script>
    new WOW().init();
</script>

<script>
    // SideNav init
    $(".button-collapse").sideNav();

    // Custom scrollbar init
    var el = document.querySelector('.custom-scrollbar');
    Ps.initialize(el);
</script>

</body>

</html>