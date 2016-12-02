@extends('layouts.admin.index')

@section('title', 'Programa')

@section('content')

    <div class="row">
        <div class="col l8 m8 ">
            <h4>Campamentos de {{$estacion}}</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">

            {{--<a href="{{route('admin.programs.create')}}">--}}
            {{--{!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Nuevo programa']) !!}--}}
            {{--</a>--}}
            <table class="table-bordered centered responsive-table">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Modulo</th>
                    <th>Calendarios</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ $program->id }}</td>
                    <td>{{ $escenario->escenario}}</td>
                    <td>{{ $disciplina->disciplina }}</td>
                    <td>{{ $modulo->modulo }}</td>
                    <td>
                        <table class="bordered striped highlight centered responsive-table">
                            <thead>
                            <tr>
                                <th>Dias</th>
                                <th>Horario</th>
                                <th>Nivel</th>
                                <th>Edad</th>
                                <th>Costo</th>
                                <th>Cupos</th>
                                <th>Cont.</th>
                                <th>Disp.</th>
                                <th>Modificar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($calendars as $calendar )
                                <tr>
                                    <td>{{ $calendar->dia}}</td>
                                    <td>{{ $calendar->start_time.'-'.$calendar->end_time }}</td>
                                    <td>{{ $calendar->nivel}}</td>
                                    <td>{{ $calendar->init_age.'-'.$calendar->end_age  }}</td>
                                    <td>{{ $calendar->mensualidad }}</td>
                                    <td>{{ $calendar->cupos }}</td>
                                    <td>{{ $calendar->contador }}</td>
                                    <td>
                                        @if( ($calendar->cupos - $calendar->contador) <=1)
                                            <span class="label label-danger">{{ $calendar->cupos - $calendar->contador }}</span>
                                        @else
                                            <span class="label label-success">{{ $calendar->cupos - $calendar->contador }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a class="label label-warning"
                                           href="{{ route('admin.calendars.edit',$calendar->id) }}">Edit</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <a href="{{ route('admin.programs.index') }}" class="tooltipped" data-position="bottom"
                           data-delay="50" data-tooltip="Regresar">
                            {!! Form::button('Regresar',['class'=>'btn waves-effect waves-light darken-1']) !!}
                        </a>
                    </td>
                </tr>
                </tbody>
            </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection
