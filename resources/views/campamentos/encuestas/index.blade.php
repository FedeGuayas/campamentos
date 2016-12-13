@extends('layouts.admin.index')

@section('title','Listado Encuestas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Encuestas</h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                <a href="{{route('admin.encuestas.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Encuesta']) !!}
                </a>
                @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Encuesta</th>
                    <th>Contador</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($encuestas as $encuesta)
                        <tr>
                            <td>{{ $encuesta->id }}</td>
                            <td>{{ $encuesta->encuesta }}</td>
                            <td>{{ $encuesta->contador }}</td>
                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$encuesta->id"]) !!}
                                <a href="{{ route('admin.encuestas.edit', $encuesta->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                @endif
                                <a href="{{ route('admin.encuestas.show', $encuesta->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                        @include ('campamentos.encuestas.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection