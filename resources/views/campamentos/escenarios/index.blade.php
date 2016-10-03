@extends('layouts.admin.index')

@section('title','Listado Escenarios')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Escenarios</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.escenarios.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Escenario']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Escenario</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($escenarios as $esc)
                        <tr>
                            <td>{{ $esc->id }}</td>
                            <td>{{ $esc->escenario }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$esc->id"]) !!}
                                <a href="{{ route('admin.escenarios.edit', $esc->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                {{--<a href="{{ route('admin.roles.show', $rol->id ) }}">--}}
                                    {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}
                                {{--<a href="{{ route('admin.roles.permisos',$rol->id  ) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Permisos">--}}
                                    {{--{!! Form::button('<i class="fa fa-key"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                {{--</a>--}}

                            </td>
                        </tr>
{{--                        @include ('campamentos.roles.modal')--}}
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection