@extends('layouts.admin.index')

@section('title','Programación')

@section('head')
    {{--CSS--}}
@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Programación para inscripciones</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <a href="{{route('admin.programs.create')}}">
                {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Nuevo programa']) !!}
            </a>
            <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                <thead>
                <th>Id</th>
                <th>Escenario</th>
                <th>Disciplina</th>
                <th>Horario</th>
                <th>Dias</th>
                <th>Modulo</th>
                <th>Nivel</th>
                <th>Matricula</th>
                <th>Mensualidad</th>
                <th>Cupos (+/-)</th>
                <th>Contador</th>
                <th>Estado (Hab/Des)</th>
                <th>Opciones</th>
                </thead>
                @foreach ($programs as $program)
                    <tr>
                        <td>{{ $program->id }}</td>
                        <td>{{ $program->escenario }}</td>
                        <td>{{ $program->disciplina }}</td>
                        <td>{{ $program->start_time.'-'. $program->end_time}}</td>
                        <td>{{ $program->dia }}</td>
                        <td>{{ $program->modulo }}</td>
                        <td>{{ $program->nivel }}</td>
                        <td>{{ $program->matricula }}</td>
                        <td>{{ $program->mensualidad }}</td>
                        <td>{{ $program->cupos }}</td>
                        <td>{{ $program->contador }}</td>
                        <td>
                            @if (($program->activated)===1)
                                <span class="label label-success">Activo</span>
                                <a href="{{ route('admin.programs.disable', $program->id)}}">
                                    {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light red darken-1']) !!}
                                </a>
                            @else
                                <span class="label label-danger">Inactivo</span>
                                <a href="{{ route('admin.programs.enable', $program->id)}}">
                                    {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            @endif
                        </td>
                        <td>
                            {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$program->id"]) !!}
                            <a href="{{ route('admin.programs.edit', $program->id ) }}">
                                {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                            </a>
                            {{--<a href="{{ route('admin.programs.show', $program->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                        </td>
                    </tr>
                    @include ('campamentos.programs.modal')
                @endforeach
            </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')
    {{--Scripts--}}
@endsection