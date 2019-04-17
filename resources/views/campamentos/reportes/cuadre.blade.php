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
                    <th>Contado</th>
                    <th>Tarjeta</th>
                    <th>Western</th>
                    <th>Tranferencia</th>
                    <th>Total</th>
                    </thead>
                    @foreach ($cuadreArray as $c )
                        <tr>
                            <td>{{ $c['usuario'] }}</td>
                            <td>{{ $c['contado'] }}</td>
                            <td>{{ $c['tarjeta'] }}</td>
                            <td>{{ $c['western'] }}</td>
                            <td>{{ $c['transferencia'] }}</td>
                            <td>$ {{number_format($c['valor'],2,'.',' ')}}</td>
                        </tr>
                   @endforeach
                    <tr>
                        <th></th>
                        <th>$ {{number_format($total['totalContado'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalTarjeta'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalWestern'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalTransferB'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalGeneral'],2,'.',' ')}}</th>
                    </tr>
                </table><!--end table-responsive-->

                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <caption>Resumen</caption>
                    </thead>
                    <tbody>
                        <th>Contado</th>
                        <th>Tarjeta</th>
                        <th>Western</th>
                        <th>Tranferencia</th>
                        <th>Total</th>
                    </tbody>
                    <tfoot>
                        <th>$ {{number_format($total['totalContado'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalTarjeta'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalWestern'],2,'.',' ')}}</th>
                        <th>$ {{number_format($total['totalTransferB'],2,'.',' ')}}</th>
                        <th style="color: red">$ {{number_format($total['totalGeneral'],2,'.',' ')}}</th>
                    </tfoot>
                </table>

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
                format: 'yyyy-mm-dd'
            });

        });




    </script>
@endsection
