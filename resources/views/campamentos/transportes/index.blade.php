@extends('layouts.admin.index')

@section('title','Listado Transportes')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Transportes por Escenarios</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.transportes.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Transporte']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Destino</th>
                    <th>Origen</th>
                    <th>Precio</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($transportes as $transp)
                        <tr>
                            <td>{{ $transp->id }}</td>
                            <td>{{ $transp->destino }}</td>
                            <td>
                                @foreach($transp->escenarios as $origen)
                                    {{ $origen->escenario }}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach($transp->escenarios as $precio)
                                    {{$precio->pivot->precio}}<br>
                                @endforeach
                            </td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$transp->id"]) !!}
                                <a href="{{ route('admin.transportes.edit', $transp->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.get_escenario',$transp->id) }}">
                                    {!! Form::button('<i class="fa fa-link"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
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