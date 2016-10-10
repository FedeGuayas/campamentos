<!DOCTYPE html>
<html lang="es" xmlns="http://www.w3.org/1999/html">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <title>@yield('title','Default') | Panel Administración</title>

    @yield('head')



    <!-- Font Awesome -->
    {!! Html::style('css/font-awesome.min.css') !!}

         <!-- Bootstrap core CSS -->
    {!! Html::style('css/bootstrap.css') !!}

            <!-- Bootstrap theme CSS -->
{{--    {!! Html::style('css/bootstrap-theme.css') !!}--}}

            <!-- BootstrapDatePicker CSS-->
    {!! Html::style('plugins/bootstrapdatepicker/css/bootstrap-datetimepicker.min.css') !!}


            <!-- Bootstrap core CSS -->
{{--    {!! Html::style('css/bootstrap-social.css') !!}--}}



            <!--Import Google Icon Font-->
    {{--<link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">--}}


    <!-- Material Design Bootstrap -->
    {{--    {!! Html::style('css/mdb.min.css') !!}--}}

            <!-- Material Design Bootstrap -->
    {!! Html::style('css/materialize.css') !!}


            <!-- Your custom styles (optional) -->
        {!! Html::style('css/styleBack.css') !!}


</head>

<body>

    {{--Header--}}
    @include('layouts.admin.partials.header')
    {{--/.Header--}}

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

        <!-- Moments for BootstrapDatePicker -->
    {!! Html::script('plugins/moments/moment.min.js') !!}

        <!-- Bootstrap tooltips -->
{!! Html::script('js/tether.min.js') !!}

        <!-- Bootstrap core JavaScript -->
{!! Html::script('js/bootstrap.min.js') !!}

        <!-- MDB core JavaScript -->
{{--{!! Html::script('js/mdb.min.js') !!}--}}

        <!-- Materialize core JavaScript -->
{!! Html::script('js/materialize.js') !!}

        <!-- BootstrapDatePicker -->
    {!! Html::script('plugins/bootstrapdatepicker/js/bootstrap-datetimepicker.min.js') !!}







    @yield('scripts')
<script>

    $(document).ready(function() {

//        combo
        $('select').material_select();

        {{--Boton dropdown--}}
         $(".dropdown-button").dropdown();


        $('.button-collapse').sideNav(
                {
                    menuWidth: 240, // Default is 240
                    edge: 'left', // Choose the horizontal origin
                    closeOnClick: true // Closes side-nav on <a> clicks, useful for Angular/Meteor
                }
        );


        $('.fixed-action-btn').openFAB();
        $('.fixed-action-btn').closeFAB();


        $('.collapsible').collapsible({
            accordion : false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
        });


        // para ventana modal de eliminar
        $('.modal-trigger').leanModal({
                    dismissible: true, // Modal can be dismissed by clicking outside of the modal
                    opacity: .5, // Opacity of modal background
                    in_duration: 300, // Transition in duration
                    out_duration: 200, // Transition out duration
                    starting_top: '4%', // Starting top style attribute
                    ending_top: '10%', // Ending top style attribute
                }
        );

        //modal respositive
        $(".modal").width($(".modal").width());
        $(".modal").height($(".modal").height());

        //tooltips
        $('.tooltipped').tooltip({delay: 50});


        //valida el datepicker k no este vacio
        function checkDate() {
            var flag=0;
            if ($('.datepicker').val() == '') {
                $('.datepicker').addClass('invalid')
                $flag=0;
            } else {
                $('.datepicker').removeClass('invalid')
                $flag=1;
            }
        }

        $('.datepicker').change(function() {
            checkDate();
        });

        $('#form_datepicker').submit(function() {
            checkDate();
            if ($flag==0){
                return false;
            }else{
                return true;
            }
        });


        $('.datepicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 50 // Creates a dropdown of 15 years to control year
//            format: 'dd/mm/yyyy'
        });



        $(function () {
            $('#datetimepicker3').datetimepicker({
                format: 'LT'
            });
        });

    });

</script>

</body>

</html>