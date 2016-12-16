@extends('layouts.admin.index')

@section('title','Listado Escenarios')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Escenarios</h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                <a href="{{route('admin.escenarios.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Escenario']) !!}
                </a>
                @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Escenario</th>
                    <th>Estado (Hab/Des)</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($escenarios as $esc)
                        <tr>
                            <td>{{ $esc->id }}</td>
                            <td>{{ $esc->escenario }}</td>
                            <td>
                                @if (($esc->activated)==='1')
                                    <span class="label label-success">Activo</span>
                                    @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.escenarios.disable', $esc->id)}}" onclick="Materialize.toast('Escenario deshabilitado', 4000,'rounded')">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light red darken-1']) !!}
                                    </a>
                                    @endif
                                @else
                                    <span class="label label-danger">Inactivo</span>
                                    @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.escenarios.enable', $esc->id)}}" onclick="Materialize.toast('Escenario habilitado', 4000,'rounded')">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                <a href="{{ route('admin.escenarios.edit', $esc->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$esc->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.escenarios.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

