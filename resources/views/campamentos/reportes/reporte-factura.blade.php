@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h3>
                Generar Formato Facturación
            </h3>
            @include('alert.success')
        </div>
    </div>
{{--filtrar --}}
    <div class="row">
        {!! Form::open (['route' => 'admin.reports.factura','method' => 'GET', 'class'=>'form_datepicker' ])!!}
        <div class="input-field col s2 ">
            {!! Form::label('start','Desde:') !!}
            {!! Form::date('start',$start,['class'=>'datepicker']) !!}
        </div>
        <div class="input-field col s2 ">
            {!! Form::label('end','Hasta:') !!}
            {!! Form::date('end',$end,['class'=>'datepicker']) !!}
        </div>
        <div class="input-field col s3 ">
            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario','class'=>'browser-default']) }}
        </div>
        {{--<div class="clearfix"></div>--}}
        <div class="col s3">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!!form::close()!!}

        {{--fin filtro--}}
        <div class="col-sm-3">
            {{--exportar--}}
            {!! Form::open (['route' => 'admin.reports.exportFactura','method' => 'GET'])!!}
            <div class="col s12">
                <div class="hidden">
                    {!! Form::date('start',$start,['class'=>'datepicker']) !!}
                    {!! Form::date('end',$end,['class'=>'datepicker']) !!}
                    {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
                </div>
                <div class="col s2 pull-right ">
                    {!! Form::button('<i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light teal tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
                </div>
            </div>
            {!! Form::close() !!}
            {{--fin exportar--}}
        </div>

    </div>
    <div class="row">

    </div>

    <div class="row">


                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Representante</th>
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
                                @if(is_null($insc->user->escenario_id))
                                @else
                                    {{ $insc->user->escenario->codigo}}
                                @endif
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


    </div><!--end div ./row-->
    {{ $inscripciones->appends(['start'=>$start,'end'=>$end,'escenario'=>$escenario])->links() }}
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
