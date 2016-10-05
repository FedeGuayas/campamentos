@extends('layouts.admin.index')

@section('title','Horarios')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Horarios</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.horarios.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Horario']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Horario Inicio</th>
                    <th>Horario Fin</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($horarios as $hora)
                        <tr>
                            <td>{{ $hora->id }}</td>
                            <td>{{ $hora->inicio }}</td>
                            <td>{{ $hora->fin }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$hora->id"]) !!}
                                <a href="{{ route('admin.horarios.edit', $hora->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
{{--                        @include ('campamentos.roles.modal')--}}
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection