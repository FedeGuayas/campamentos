@extends('layouts.admin.index')

@section('title','Listado Usuarios')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Usuarios</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            @if ( Auth::user()->hasRole('administrator'))
                <a href="{{route('admin.users.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear usuario']) !!}
                </a>
            @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Usuario</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($usuarios as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->getNameAttribute() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>@foreach ($user->roles as $role)
                                    {{ $role->display_name }}<br>

                                @endforeach
                            </td>
                            <td>
                                @if ( Auth::user()->hasRole('administrator'))
                                <a href="{{ route('admin.users.edit', $user->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.users.show', $user->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-eye"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.users.roles', $user->id ) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Roles">
                                    {!! Form::button('<i class="tiny fa fa-key"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$user->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.users.modal')
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection