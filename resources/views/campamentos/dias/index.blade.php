@extends('layouts.admin.index')

@section('title','Dias')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Dias</h4>

            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.dias.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear MDias']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Dias Semana</th>
                    {{--<th>Estado (Hab/Des)</th>--}}
                    <th>Opciones</th>
                    </thead>
                    @foreach ($dias as $dia)
                        <tr>
                            <td>{{ $dia->id }}</td>
                            <td>{{ $dia->dia }}</td>
                            {{--<td>--}}
                                {{--@if (($dia->activated)===1)--}}
                                    {{--<span class="label label-success">Activo</span>--}}
                                    {{--<a href="{{ route('admin.dias.disable', $dia->id)}}">--}}
                                        {{--{!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light red darken-1']) !!}--}}
                                    {{--</a>--}}
                                {{--@else--}}
                                    {{--<span class="label label-danger">Inactivo</span>--}}
                                    {{--<a href="{{ route('admin.dias.enable', $dia->id)}}">--}}
                                        {{--{!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$dia->id"]) !!}
                                <a href="{{ route('admin.dias.edit', $dia->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                        @include ('campamentos.dias.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection