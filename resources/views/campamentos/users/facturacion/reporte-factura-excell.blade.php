@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h5>
                Facturación usuario : {{$user->getNameAttribute()}}
            </h5>
            @include('alert.success')
        </div>
    </div>

    <div class="row">
        @include('campamentos.users.facturacion.search')
        <div class="col-sm-3">
            @include('campamentos.users.facturacion.export-factura-filter')
        </div>

    </div>


    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" style="font-size: 10px;">
                    <thead>
                    <tr>
                        <th>Apellidos_A.</th>
                        <th>Nombre_A.</th>
                        <th>Modulo</th>
                        <th>Escenario</th>
                        <th>Comprobante</th>
                        <th>Valor</th>
                        <th>Descuento</th>
                        <th>Estado</th>
                        <th>Fecha_Cobro</th>
                        <th>Forma_Pago</th>
                        <th>Pto_Cobro</th>
                        <th>Usuario</th>
                    </tr>
                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                @if ($insc->alumno_id == 0)
                                    {{$insc->factura->representante->persona->apellidos}}
                                @else
                                    {{$insc->alumno->persona->apellidos}}
                                @endif
                            </td>
                            <td>
                                @if ($insc->alumno_id == 0)
                                    {{$insc->factura->representante->persona->nombres}}
                                @else
                                    {{$insc->alumno->persona->nombres}}
                                @endif
                            </td>
                            <td>
                                {{$insc->calendar->program->modulo->modulo}}
                            </td>
                            <td>
                                {{$insc->calendar->program->escenario->escenario}}
                            </td>
                            <td>
                                {{ $insc->factura_id }}
                            </td>
                            <td>
                                {{number_format($insc->factura->total,2,'.',' ')}}
                            </td>
                            <td>
                                {{number_format($insc->factura->descuento,2,'.',' ')}}
                            </td>
                            <td>
                                {{$insc->estado}}
                            </td>
                            <td>
                                {{$insc->factura->created_at->format('d/m/Y')}}
                            </td>
                            <td>
                                {{ $insc->factura->pago->forma }}
                            </td>
                            <td>
                                @if ($insc->escenario)
                                    {{ $insc->escenario->escenario }}
                                @endif
                            </td>
                            <td>
                                {{ $insc->user->getNameAttribute() }}
                            </td>
                        </tr>
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            //valida el datepicker k no este vacio
            function checkDate() {

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

            $('.form_datepicker').submit(function () {
                checkDate();
                if ($flag == 0) {
                    return false;
                } else {
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 15 years to control year
                format: 'yyyy-mm-dd'
            });

        });

        $(document).ready(function () {
            $("#filtrar").on('click', function () {
                var exportar = $(".exportar");

                exportar.prop("disabled", false);
            });

        });

    </script>

@endsection
