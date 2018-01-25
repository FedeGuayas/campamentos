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
@endsection

@section('scripts')
    <script>

        $(document).ready(function () {


            $('.fixed-action-btn').openFAB();
            $('.fixed-action-btn').closeFAB();

            $('.collapsible').collapsible({
                accordion: false // A setting that changes the collapsible behavior to expandable instead of the default accordion style
            });

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
