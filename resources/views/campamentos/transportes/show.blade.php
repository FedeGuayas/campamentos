@extends('layouts.admin.index')

@section('title', 'Transporte')

@section('content')

    <div class="row">
        <div class="col l12 m12 s12">
            <div>
                <h5 class="header teal-text text-darken-2">{{$transporte->destino}}</h5>
                @include('alert.success')
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Origen</th>
                    <th>Precio</th>
                    <th>Opciones</th>
                    </thead>
                        <tr>
                            @foreach ($transporte->escenarios as $escenario)
                                <td>{{ $escenario->id }}</td>
                                <td>{{ $escenario->escenario }}</td>
                                <td>{{ $escenario->pivot->precio }}</td>
                                <td>
                                    {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$escenario->id"]) !!}

                                </td>
                        </tr>
                    @include ('campamentos.transportes.modalEscenario')
                    @endforeach
                  </table><!--end table-responsive-->
                <a href="{{ route('admin.transportes.index') }}" class="tooltipped" data-position="bottom" data-delay="50" data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection