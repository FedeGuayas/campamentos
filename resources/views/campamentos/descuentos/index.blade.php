@extends('layouts.admin.index')

@section('title','Descuentos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Descuentos</h4>
        </div>
    </div>

    <div class="row">

        <div class="col s12">
            <div class="row">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                    <a href="{{route('admin.tipo_descuentos.create')}}">
                        {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear descuento']) !!}
                    </a>
                @endif
            </div>

                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Descuento</th>
                    <th>Multiplicador</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($descuentos as $desc)
                        <tr>
                            <td>{{ $desc->id }}</td>
                            <td>{{ $desc->nombre. ' ( '.$desc->porciento.'% ) ' }}</td>
                            <td>{{ $desc->multiplicador }}</td>
                            <td>{{ $desc->descripcion }}</td>
                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.tipo_descuentos.edit', $desc->id ) }}">
                                        {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$desc->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.descuentos.modal')
                    @endforeach
                </table><!--end table-responsive-->

        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection