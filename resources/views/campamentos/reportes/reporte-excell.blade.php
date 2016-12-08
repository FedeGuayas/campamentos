@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">

        <div class="col l12 col m6 col s12">
            <h3>
                Generar Reporte
            </h3>
            @include('alert.success')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-5">
            <div class="form-inline">
                FIltros
                {{--@include('runner.comprobantes.search')--}}
            </div>
        </div>
        <div class="col-lg-2">
            exportar excel
            {{--@include('runner.comprobantes.reportes.exportarComprobantes')--}}
        </div>

        <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">

            {{--@include('runner.comprobantes.searchCedula')--}}

        </div>

    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>CI</th>
                    <th>Edad</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Dias</th>
                    <th>Nivel</th>
                    <th>Representante</th>
                    <th>Fact</th>
                    <th>Valor</th>
                    <th>Descuento</th>
                    <th>Usuario</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($cursos as $curso )
                        <tr>
                            <td>app al</td>
                            <td>nombres</td>
                            <td>ced</td>
                            <td>edad</td>
                            <td>{{ $curso->program->escenario->escenario }}</td>
                            <td>{{ $curso->program->disciplina->disciplina }}</td>
                            <td>{{ $curso->dia->dia }}</td>
                            <td>{{ $curso->nivel }}</td>
                            <td>rep</td>
                            <td>{{ $curso->factura_id }}</td>
                            <td>$ {{ number_format($curso->total,2,'.',' ') }}</td>
                            <td>$ {{ number_format($curso->descuento,2,'.',' ') }}</td>
                            <td>{{ $curso->user_id }}</td>
                            {{--<td>--}}
                                {{--@if((Auth::user()->rols_id==1) )--}}
                                    {{--<a href="{{ URL::action('ComprobanteController@show', $pago->comp_id ) }}">--}}
                                        {{--{!! Form::button('Editar',['class'=>'label pull-right label-primary']) !!}--}}
                                    {{--</a>--}}
                                {{--@endif--}}
                                {{--<a href="{{ URL::action('ComprobanteController@pagoPDF',$pago->comp_id ) }}">--}}
                                    {{--{!! Form::button('PDF',['class'=>'label pull-right bg-red']) !!}--}}
                                {{--</a>--}}
                            {{--</td>--}}
                        {{--</tr>--}}
                        {{--@include ('runner.comprobantes.modal')--}}
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
{{--            {{ $pagos->appends(['usuario'=>$usuario, 'escenario'=>$escenario, 'fecha'=>$fecha])->links() }}--}}
            {{--<div class="text-bold text-primary">Total: <span class="bg-blue-active badge"> {{ $pagos->total()}}</span>--}}
            {{--</div>--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

@endsection
