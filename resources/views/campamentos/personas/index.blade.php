@extends('layouts.admin.index')

@section('title','Listado Personas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Personas</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

                <a href="{{route('admin.personas.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear persona']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Tipo Doc</th>
                    <th>Número Doc</th>
                    <th>Género</th>
                    <th>Fecha Nac</th>
                    <th>Email</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($personas as $per)
                        <tr>
                            <td>{{ $per->id }}</td>
                            <td>{{ $per->nombres }}</td>
                            <td>{{ $per->apellidos }}</td>
                            <td>{{ $per->tipo_doc }}</td>
                            <td>{{ $per->num_doc }}</td>
                            <td>{{ $per->genero }}</td>
                            <td>{{ $per->fecha_nac }}</td>
                            <td>{{ $per->email }}</td>
                            <td>{{ $per->direccion }}</td>
                            <td>{{ $per->telefono }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$per->id"]) !!}
                                <a href="{{ route('admin.personas.edit', $per->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.personas.show', $per->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                        @include ('campamentos.personas.modal')
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection