@extends('layouts.front.master-plane')

@section('body')

    <header>
        {{--Nav--}}
        @include('layouts.front.navUp')
    </header>

    <div class="container">
        <div class="row">
            <div class="col l12">
                <h5 class="page-header">@yield('encabezado')</h5>
            </div><!-- /.col l12 -->
        </div>  <!-- /.row -->
        <div class="row">
            <main>
                {{--Contenido--}}
                @yield('content')
            </main>
        </div><!-- /.row -->
    </div>

    <footer>
        {{--FOOTER--}}
        @include('layouts.front.footer')
    </footer>

@section('scripts')
    <script>
        $(document).ready(function () {

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
                accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
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
                var flag = 0;
                if ($('.datepicker').val() == '') {
                    $('.datepicker').addClass('invalid')
                    $flag = 0;
                } else {
                    $('.datepicker').removeClass('invalid')
                    $flag = 1;
                }
            }

            $('.datepicker').change(function () {
                checkDate();
            });

            $('#form_datepicker').submit(function () {
                checkDate();
                if ($flag == 0) {
                    return false;
                } else {
                    return true;
                }
            });

            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 50 // Creates a dropdown of 15 years to control year
                //            format: 'dd/mm/yyyy'
            });

        });
    </script>

@endsection

@endsection
