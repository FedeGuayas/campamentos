@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12">
            @include('alert.success')
            <h3>Cobros diarios</h3>
            @include('campamentos.reportes.searchCuadre')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Usuarios</th>
                    <th>Inscripciones</th>
                    <th>Valor</th>
                    </thead>
                    @foreach ($cuadreArray as $c )
                        <tr>
                            <td>{{ $c['nombre'] }}</td>
                            <td>{{ $c['cantidad'] }}</td>
                            <td>{{ $c['valor'] }}</td>
                        </tr>
                   @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->
@endsection


@section('scripts')
    <script>
        $(document).ready( function () {

            $('select').addClass("browser-default");
            $('select').material_select();
        });


        $(document).ready(function() {

            //valida el datepicker k no este vacio
            function checkDate() {

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

            $('.form_datepicker').submit(function() {
                checkDate();
                if ($flag==0){
                    return false;
                }else{
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 15 years to control year
                format: 'yyyy/mm/dd'
            });

        });




    </script>
@endsection
