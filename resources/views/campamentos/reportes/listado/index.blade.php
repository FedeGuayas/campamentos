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
            <h4>Campamentos Deportivos. Resumen</h4>
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.general','method' => 'GET', 'class'=>'form_datepicker' ])!!}

        <div class="input-field col s12 m6">
            {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione *','id'=>'modulo_id','class'=>'validate','required']) !!}
            {!! Form::label('modulo_id','Modulo:') !!}
            {{--{{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}--}}

        </div>
        <div class="input-field col s12 m6 ">
            {!! Form::select('escenario_id',['placeholder'=>'Seleccione ...'],null,['id'=>'escenario_id','required']) !!}
            {!! Form::label('escenario_id', 'Escenarios:*') !!}
            {{--            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}--}}
        </div>
        <div class="input-field col s12 m6 ">
            {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'disciplina_id','required']) !!}
            {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
            {{--            {{Form::select('disciplina',$disciplinaSelect,$disciplina,['id'=>'disciplina']) }}--}}
        </div>
        <div class="input-field col s12 m6">
            {{--            {{Form::select('horario',$horarioSelect,$horario,['id'=>'horario']) }}--}}
            {!! Form::select('horario_id[]', ['placeholder'=>'Seleccione ...'],null, ['id'=>'horario_id','multiple']) !!}
            {!! Form::label('horario_id', 'Horario:') !!}
        </div>
        <div class="col s1 right">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!! Form::close() !!}
    </div>


    <table class="table centered">
        <thead>
        </thead>
        <tbody>
        <tr>

            <td>
                <table class="bordered striped highlight centered" id="tabla_listado">
                    <thead>
                    <tr style="font-size: 8px">
                        <th>
                            @if (count($moduloSelect)>0)
                                Modulo: {{$moduloSelect->modulo}}
                            @else
                                Modulo
                            @endif
                        </th>
                        <th>
                            @if (count($escenarioSelect)>0)
                                Escenario: {{$escenarioSelect->escenario}}
                            @else
                                Escenario
                            @endif
                        </th>
                        <th>
                            @if (count($disciplinaSelect)>0)
                                Disciplina: {{$disciplinaSelect->disciplina}}
                            @else
                                Disciplina
                            @endif
                        </th>
                        <th colspan="3">
                            <div class="right" style="text-align: left">
                                {{--<p>--}}
                                    <input class="filled-in" type="checkbox" id="azul" checked="checked"/>
                                    <label style="color: #00b0ff" for="azul">< 1/3</label>
                                    <input class="filled-in" type="checkbox" id="rojo" checked="checked"/>
                                    <label style="color: red" for="rojo">agotado</label>
                                    <input class="filled-in" type="checkbox" id="verde" checked="checked"/>
                                    <label style="color: #00897b" for="verde">> 1/3</label>
                                {{--</p>--}}
                            </div>
                        </th>
                    </tr>
                    <tr>
                        {{--<th>id</th>--}}
                        <th>Dias</th>
                        <th>Horario</th>
                        <th>Cupos</th>
                        <th>Inscritos</th>
                        <th>Disponible</th>
                        <th>Lista</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cursos as $curso)
                        <tr>
                            {{--<td>{{ $curso->id }}</td>--}}
                            <td>{{ $curso->dia}}</td>
                            <td>{{ $curso->start_time.'-'.$curso->end_time}}</td>
                            <td>{{ $curso->cupos}}</td>
                            <td>{{ $curso->total}}</td>
                            <td>
                                @if( ($curso->cupos - $curso->total) <=1)
                                    <span class="label label-danger">{{ $curso->cupos - $curso->contador }}</span>

                                @elseif(($curso->cupos - $curso->total) <= ($curso->cupos)/3)
                                    <span class="label label-success">{{ $curso->cupos - $curso->total }}</span>

                                @elseif(($curso->cupos - $curso->total) >= ($curso->cupos)/3)
                                    <span class="label blue">{{ $curso->cupos - $curso->total }}</span>
                                @else
                                    {{ $curso->cupos - $curso->total }}
                                @endif
                            </td>

                            <td>
                                {{--@if (Auth::user()->hasRole(['planner','administrator']))--}}
                                <a href="{{ route('admin.reports.exportGeneral', $curso->id ) }}" target="_blank">
                                    {!! Form::button('<i class="tiny fa fa-file-pdf-o"></i>',['class'=>'label waves-effect waves-light orange accent-4']) !!}
                                </a>
                                {{--@endif--}}
                                @if (Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.calendars.edit', $curso ) }}">
                                        {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label  waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table><!--end table-responsive-->

@endsection

@section('scripts')

    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdownReportes.js?ver=2.1") }}" type="text/javascript"></script>

    <script>
        $(document).ready(function () {

            $("#azul").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label blue') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label blue') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

            $("#rojo").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label label-danger') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label label-danger') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

            $("#verde").on('change', function () {
                if ($(this).is(':checked')) {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label label-success') {
                            $(this).parent().show();
                        }
                    });

                } else {
                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                    $("#tabla_listado tr td").each(function () {
                        var celda=$(this).find('span');
                        if (celda.attr('class')=='label label-success') {
                            $(this).parent().hide();
                        }
                    });
                }
            });

        });
    </script>




@endsection