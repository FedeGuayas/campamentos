@extends('layouts.admin.index')

@section('title','Listado Permisos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Permisos</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.permissions.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn waves-effect waves-light']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Permiso</th>
                    <th>Nombre para mostrar</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($permisos as $per)
                        <tr>
                            <td>{{ $per->id }}</td>
                            <td>{{ $per->name }}</td>
                            <td>{{ $per->display_name }}</td>
                            <td>{{ $per->description }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$per->id"]) !!}
                                <a href="{{ route('admin.permissions.edit', $per->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.permissions.show', $per->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>

                            </td>
                        </tr>
                        @include ('campamentos.permissions.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection