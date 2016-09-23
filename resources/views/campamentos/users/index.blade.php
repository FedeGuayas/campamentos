@extends('layouts.admin.index')

@section('title','Listado Usuarios')

@section('content')

    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            @include('alert.success')
            <h3>Listado de Usuarios
                <a href="{{route('admin.users.create')}}">
                {!! Form::button('Nuevo',['class'=>'btn waves-effect waves-light']) !!}
                </a>
            </h3>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($usuarios as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->getNameAttribute() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ 'rolll' }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$user->id"]) !!}
                                <a href="{{ route('admin.users.show', $user->id ) }}">
                                    {!! Form::button('<i class="material-icons right">visibility</i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>

                            </td>
                        </tr>
                        @include ('campamentos.users.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection