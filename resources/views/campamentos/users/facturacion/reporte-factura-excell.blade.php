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
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover" style="font-size: 10px;">
                    <thead>
                    <th>Fecha Insc</th>
                    <th>Representante</th>
                    <th>RUC</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Email</th>
                    <th>Alumno</th>
                    <th>Modulo</th>
                    <th>Horario</th>
                    <th>Escenario</th>
                    <th>Valor</th>
                    <th>Forma Pago</th>
                    <th>Registro</th>
                    <th>Pto Cobro</th>

                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                {{$insc->created_at->format('d/m/Y')}}
                            </td>
                            <td>
                                {{$insc->factura->representante->persona->getNombreAttribute()}}
                            </td>
                            <td>
                                {{(int)$insc->factura->representante->persona->num_doc}}
                            </td>
                            <td>
                                {{$insc->factura->representante->persona->direccion}}
                            </td>
                            <td>
                                {{(string)$insc->factura->representante->persona->telefono}}
                            </td>
                            <td>
                                {{$insc->factura->representante->persona->email}}
                            </td>
                            <td>
                                @if ($insc->alumno_id == 0)
                                    {{$insc->factura->representante->persona->getNombreAttribute()}}
                                @else
                                    {{$insc->alumno->persona->getNombreAttribute()}}
                                @endif
                            </td>
                            <td>
                                {{$insc->calendar->program->modulo->modulo}}
                            </td>
                            <td>
                                {{$insc->calendar->horario->start_time.' - '.$insc->calendar->horario->end_time}}
                            </td>
                            <td>
                                {{$insc->calendar->program->escenario->escenario}}
                            </td>
                            <td>
                                {{round(($insc->factura->total) , 3)}}
                            </td>
                            <td>
                                {{ $insc->factura->pago->forma }}
                            </td>
                            <td>
                                {{ $insc->id }}
                            </td>
                            <td>
{{--                                {{ $insc->escenario->escenario }}--}}
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
