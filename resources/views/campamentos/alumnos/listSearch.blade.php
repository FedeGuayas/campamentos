@extends('layouts.admin.index')

@section('title','Alumnos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Alumnos</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

                <a href="{{route('admin.alumnos.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear alumno']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Nombres y Apellidos</th>
                    <th>Identificación</th>
                    <th>Tipo</th>
                    <th>Género</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($representantes as $per)
                        <tr>
                            <td>{{ $per->id }}</td>
                            <td>{{ $per->getNombreAttribute() }}</td>
                            <td>{{ $per->num_doc }}</td>
                            <td>{{ $per->tipo_doc }}</td>
                            <td>{{ $per->genero }}</td>
                            <td>
                                {{--{!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$al->id"]) !!}--}}
                                {{--<a href="{{ route('admin.alumnos.edit', $al->id ) }}">--}}
                                    {{--{!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                                {{--<a href="{{ route('admin.alumnos.show', $al->id ) }}">--}}
                                    {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                            </td>
                        </tr>
{{--                        @include ('campamentos.alumnos.modal')--}}
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection