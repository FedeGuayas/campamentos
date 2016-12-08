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
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>CI</th>
                    <th>Modulo</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Representante</th>
                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->apellidos }}
                                @else
                                    {{ $insc->alumno->persona->apellidos }}
                                @endif
                            </td>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->nombres }}
                                @else
                                    {{ $insc->alumno->persona->nombres }}
                                @endif
                            </td>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->num_doc  }}
                                @else
                                    {{$insc->alumno['persona']['num_doc']}}
                                @endif
                            </td>
                            <td>{{$insc->calendar->program->modulo->modulo}}</td>
                            <td>{{ $insc->calendar['program']->escenario->escenario }}</td>
                            <td>{{ $insc->calendar['program']->disciplina->disciplina }}</td>
                            <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>

                        </tr>
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
