@extends('layouts.admin.index')

@section('title','Listado Profesores')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Profesores</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            @if ( Auth::user()->hasRole(['administrator','planner']))
                <a href="{{route('admin.profesors.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear usuario']) !!}
                </a>
            @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Nombre</th>
                    <th>Apellidos</th>
                    <th>Documento</th>
                    <th>Cursos</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($profesors as $profe)
                        <tr>
                            <td>{{ $profe->id }}</td>
                            <td>{{ $profe->nombres }}</td>
                            <td>{{ $profe->apellidos }}</td>
                            <td>{{ $profe->num_doc }}</td>
                            <td>asjkf</td>
                            {{--<td>@foreach ($profe->curso as $curso)--}}
                                    {{--{{ $curso->display_name }}<br>--}}

                                {{--@endforeach--}}
                            {{--</td>--}}
                            <td>
                                @if ( Auth::user()->hasRole(['administrator','planner']))
                                <a href="{{ route('admin.profesors.edit', $profe->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$profe->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.profesors.modal')
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection