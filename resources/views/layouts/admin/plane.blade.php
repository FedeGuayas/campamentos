<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">



        <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}

            <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.css') !!}


            <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap-social.css') !!}

            <!-- Bootstrap theme CSS -->
    {!! Html::style('css/bootstrap-theme.css') !!}

            <!-- Material Design Bootstrap -->
    {{--    {!! Html::style('css/mdb.min.css') !!}--}}

            <!-- Material Design Bootstrap -->
    {!! Html::style('css/materialize.css') !!}

            <!-- Your custom styles (optional) -->
    {!! Html::style('css/styleBack.css') !!}

            <!-- Datatables style bootstrap -->
    {!! Html::style('plugins/datatables/dataTables.bootstrap.css') !!}

    @yield('head')


</head>

<body>



    {{--Main--}}
    <main style="padding-top: 20px">
        <div class="container" >
            @yield('content')
        </div>
    </main>
    {{--/.Main--}}

    {{--Footer--}}
{{--   @include('layouts.admin.partials.footer')--}}



<!-- SCRIPTS -->

    <!-- JQuery -->
{!! Html::script('js/jquery-3.1.0.min.js') !!}

        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}

        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}

        <!-- MDB core JavaScript -->
{{--{!! Html::script('js/mdb.min.js') !!}--}}

        <!-- Materialize core JavaScript -->
{!! Html::script('js/materialize.js') !!}

        <!-- Datatables -->
    {!! Html::script('plugins/datatables/jquery.dataTables.js') !!}
    {!! Html::script('plugins/datatables/jquery.dataTables.min.js') !!}
    {!! Html::script('plugins/datatables/dataTables.bootstrap.min.js') !!}


    @yield('scripts')

</body>

</html>