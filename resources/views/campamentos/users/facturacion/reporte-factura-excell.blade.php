@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h3>
                Generar Formato Facturación Masiva
            </h3>
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

    </div>

    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Nombre Representante</th>
                    <th>CI</th>
                    <th>Dirección</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Fecha</th>
                    <th>Disciplina</th>
                    <th>Escenario</th>
                    <th>Cod-Escenario</th>
                    <th>Valor</th>
                    <th>Forma de Pago</th>
                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                {{ $insc->factura->representante->persona->getNombreAttribute() }}
                            </td>
                            <td>
                                {{ $insc->factura->representante->persona->num_doc}}
                            </td>
                            <td>
                                {{ $insc->factura->representante->persona->direccion}}
                            </td>
                            <td>
                                {{ $insc->factura->representante->persona->telefono}}
                            </td>
                            <td>
                                {{ $insc->factura->representante->persona->email}}
                            </td>
                            <td>
                                {{ $insc->factura->created_at}}
                            </td>
                            <td>
                                {{ $insc->calendar->program->disciplina->disciplina}}
                            </td>
                            <td>
                                {{ $insc->calendar->program->escenario->escenario}}
                            </td>
                            <td>
                                {{ $insc->calendar->program->escenario->codigo}}
                            </td>
                            <td>
                                {{ $insc->factura->total}}
                            </td>
                            <td>
                                {{ $insc->factura->pago->forma}}
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
                format: 'yyyy/mm/dd'
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
