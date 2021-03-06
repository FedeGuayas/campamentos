@extends('layouts.admin.index')

@section('title','Formas de Pago')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Formas de Pago</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                <a href="{{route('admin.fpagos.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Forma de Pago']) !!}
                </a>
                @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Forma de Pago</th>
                    <th>Descripción</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($fpagos as $fpago)
                        <tr>
                            <td>{{ $fpago->id }}</td>
                            <td>{{ $fpago->forma }}</td>
                            <td>{{ $fpago->descripcion }}</td>
                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                <a href="{{ route('admin.fpagos.edit', $fpago->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$fpago->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.fpagos.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection