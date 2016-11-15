@extends('layouts.admin.index')

@section('title','Calendario')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Calendario de programas para campamentos</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            {{--<a href="{{route('admin.programs.create')}}">--}}
                {{--{!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Nuevo programa']) !!}--}}
            {{--</a>--}}
            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                <th>Id</th>
                <th>Escenario</th>
                <th>Disciplina</th>
                <th>Modulo</th>
                <th>Días</th>
                <th>Horario</th>
                <th>Cupos (+/-)</th>
                <th>Disponibilidad</th>
                <th>Opciones</th>
                </thead>
                @foreach ($calendars as $calendar)
                    <tr>
                        <td>{{ $calendar->id }}</td>
                        <td>{{ $calendar->escenario}}</td>
                        <td>{{ $calendar->disciplina }}</td>
                        <td>{{ $calendar->modulo}}</td>
                        <td>{{ $calendar->dia}}</td>
                        <td>{{ $calendar->start_time.'-'.$calendar->end_time}}</td>
                        <td>{{ $calendar->cupos}}</td>
                        <td>dispopnible?</td>
                        <td>
                            {{--@if (($program->activated)===1)--}}
                                {{--<span class="label label-success">Activo</span>--}}
                                {{--<a href="{{ route('admin.programs.disable', $program->id)}}">--}}
                                    {{--{!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light red darken-1']) !!}--}}
                                {{--</a>--}}
                            {{--@else--}}
                                {{--<span class="label label-danger">Inactivo</span>--}}
                                {{--<a href="{{ route('admin.programs.enable', $program->id)}}">--}}
                                    {{--{!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                            {{--@endif--}}
                            <a href="{{ route('admin.calendars.edit', $calendar ) }}">
                                {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                            </a>
                        </td>
                        {{--<td>--}}
                            {{--{!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$program->id"]) !!}--}}

                            {{--<a href="{{ route('admin.programs.show', $program->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--<a href="{{ route('admin.calendars.create', $program->id ) }}">--}}
                            {{--{!! Form::button('<i class="fa fa-calendar left" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                        {{--</td>--}}
                    </tr>
                    {{--@include ('campamentos.programs.modal')--}}
                @endforeach
            </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


{{--@section('scripts')--}}
    {{--Scripts--}}
{{--@endsection--}}