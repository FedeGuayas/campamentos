@extends('layouts.admin.index')

@section('title', 'Usuario')

@section('content')

    <div class="row">
        <div class="col l12 m12 s12">
            <div>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Email</th>
                    <th>Imagen</th>
                    <th>Creado</th>
                    <th>Modificado</th>
                    <th>Permisos</th>
                    <th>Opciones</th>
                    </thead>
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->first_name }}</td>
                            <td>{{ $user->last_name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->avatar }}</td>
                            <td>{{ $user->created_at }}</td>
                            <td>{{ $user->updated_at }}</td>
                            <td>{{ 'roles' }}</td>
                            <td>
                                <a href="{{ route('admin.users.index') }}">
                                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                  </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection