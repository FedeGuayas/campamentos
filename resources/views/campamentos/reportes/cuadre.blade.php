@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')
    <div class="row">
        <div class="col-lg-10 col-md-8 col-sm-8 col-xs-12">
            @include('alert.success')
            <h3>Cobros diarios</h3>
            @include('campamentos.reportes.searchCuadre')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Usuarios</th>
                    <th>Inscripciones</th>
                    <th>Valor</th>
                    </thead>
                    @foreach ($cuadreArray as $c )
                        <tr>
                            <td>{{ $c['nombre'] }}</td>
                            <td>{{ $c['cantidad'] }}</td>
                            <td>{{ $c['valor'] }}</td>
                        </tr>
                   @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->
@endsection