@extends('layouts.admin.index')

@section('title','Cursos')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l12 m12 s12">
            @include('alert.success')
            <h5>Campamentos Deportivos. Recaudado por Escenarios</h5>
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.resumen','method' => 'GET', 'class'=>'form_datepicker' ])!!}

        <div class="input-field col s3 ">
            {{Form::select('modulo',$modulos,$modulo,['id'=>'modulo', 'placeholder'=>'seleccione el modulo*']) }}
        </div>

        {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}

        {!! Form::close() !!}
    </div>


    <table class="table  responsive-table">
        <thead>
        </thead>
        <tbody>
        <tr>
            <td>
                <table class="bordered striped highlight  responsive-table" id="tabla_listado">
                    <thead>
                    <tr class="teal-text">
                        <th>ESCENARIOS</th>
                        <th>INSCRITOS</th>
                        <th>RECAUDADO</th>
                    </tr>

                    @foreach($resumenEscenario as $escenario)
                        <tr>
                            <th>
                                {{$escenario['escenario']}}
                            </th>

                            <th>
                                {{$escenario['inscritos']}}
                            </th>
                            <th>
                                $ {{number_format($escenario['factura'],3,'.',' ')}}
                            </th>
                        </tr>
                    @endforeach

                    </thead>
                    <tbody>
                    <tr class="teal-text">
                        <th>TOTAL</th>
                        <th>{{$totalInscritos['total']}}</th>
                        <th>$ {{number_format($totalRecaudado['total'],3,'.',' ')}} </th>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table><!--end table-responsive-->

    {{--Desglose--}}
    <hr>

    {{--<div>--}}
        {{--<p>DESGLOSE</p>--}}
        {{--<table class="table  responsive-table">--}}
            {{--<thead>--}}
            {{--<tr class="teal-text">--}}


            {{--</tr>--}}
            {{--</thead>--}}
            {{--<tbody>--}}
            {{--@foreach($resumenEscenarioDisciplina as $disc)--}}
                {{--<tr class="teal-text">--}}
                    {{--<th>--}}
{{--                        @foreach($disc as $esc)--}}
{{--                        {{array_first($disc)}}--}}
                        {{--@endforeach--}}
                    {{--</th>--}}

                    {{--{{$disc['escenario']}}--}}
                {{--</tr>--}}
                {{--<td>--}}
                    {{--<table class="bordered striped highlight  responsive-table" id="tabla_listado">--}}
                        {{--<thead>--}}
                        {{--@foreach($disc as $disciplina)--}}

                        {{--<tr>--}}
                            {{--<th>--}}
                                {{--{{array_get($disciplina, '0.disciplina')}}--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--{{$disciplina['inscritos']}}imsc--}}
                            {{--</th>--}}
                            {{--<th>--}}
                                {{--$ {{ number_format($disciplina['valor'],2,'.',' ')}}--}}{{--costo--}}
                            {{--</th>--}}
                        {{--</tr>--}}

                        {{--@endforeach--}}
                        {{--</thead>--}}
                        {{--<tbody>--}}
                        {{--<tr class="teal-text">--}}
                            {{--<th>TOTAL</th>--}}
                            {{--                        <th>{{$totalInscritos['total']}}</th>--}}
                            {{--                        <th>$ {{number_format($totalRecaudado['total'],2,'.',' ')}} </th>--}}
                        {{--</tr>--}}

                        {{--</tbody>--}}
                    {{--</table>--}}
                {{--</td>--}}
            {{--@endforeach--}}

            {{--</tbody>--}}
        {{--</table><!--end table-responsive-->--}}
    {{--</div>--}}






@endsection

@section('scripts')

    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdownReportes.js") }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {

            $("#azul").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label blue') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label blue') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

            $("#rojo").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label label-danger') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label label-danger') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

            $("#verde").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label label-success') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda = $(this).find('span');
                        if (celda.attr('class') == 'label label-success') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

        });
    </script>




@endsection