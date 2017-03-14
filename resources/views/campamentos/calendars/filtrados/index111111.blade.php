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
            <h4>Listado de cursos</h4>
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.calendars.filters','method' => 'GET', 'class'=>'form_datepicker' ])!!}

        <div class="input-field col s3 ">
            {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione *','id'=>'modulo_id','required']) !!}
            {!! Form::label('modulo_id','Modulo:') !!}
        </div>
        <div class="input-field col s3 ">
            {!! Form::select('escenario_id',['placeholder'=>'Seleccione ...'],null,['id'=>'escenario_id','required']) !!}
            {!! Form::label('escenario_id', 'Escenarios:*') !!}
        </div>
        <div class="input-field col s3 ">
            {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'disciplina_id','required']) !!}
            {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
        </div>
        {{--<div class="input-field col s3 ">--}}
            {{--{!! Form::select('horario_id[]', ['placeholder'=>'Seleccione ...'],null, ['id'=>'horario_id','multiple']) !!}--}}
            {{--{!! Form::label('horario_id', 'Horario:') !!}--}}
        {{--</div>--}}
        <div class="col s1 right">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!! Form::close() !!}
    </div>


    <table class="table centered responsive-table">
        <thead>
        </thead>
        <tbody>
        <tr>

            <td>
                <table class="bordered striped highlight centered responsive-table">
                    <thead>
                    <tr>
                        <th>
                            @if (count($moduloSelect)>0)
                                {{$moduloSelect->modulo}} /
                            @else
                                Modulo /
                            @endif
                        </th>
                        <th>
                            @if (count($escenarioSelect)>0)
                                {{$escenarioSelect->escenario}} /
                            @else
                                Escenario /
                            @endif
                        </th>
                        <th>
                            @if (count($disciplinaSelect)>0)
                                {{$disciplinaSelect->disciplina}}
                            @else
                                Disciplina
                            @endif
                        </th>
                    </tr>
                    <tr>
                        <th>Id</th>
                        <th>Días</th>
                        <th>Horario</th>
                        <th>Cupos</th>
                        <th>Inscritos</th>
                        <th>Disponibilidad</th>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($cursos as $curso)
                        <tr>
                            <td>{{ $curso->id }}</td>

                            <td>{{ $curso->dia}}</td>
                            <td>{{ $curso->start_time.'-'.$curso->end_time}}</td>
                            <td>{{ $curso->cupos}}</td>
                            <td>
                                @if($curso->contador < (($curso->cupos) / 3))
                                <span class="label blue">{{ $curso->contador}}</span>
                                @else
                                    {{ $curso->contador}}
                                @endif
                            </td>
                            <td>
                                @if( ($curso->cupos - $curso->contador) <=1)
                                    <span class="label label-danger">{{ $curso->cupos - $curso->contador }}</span>
                                @else
                                    <span class="label label-success">{{ $curso->cupos - $curso->contador }}</span>
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
    <script src="{{ asset("js/dropdownReportes.js") }}" type="text/javascript"></script>




@endsection