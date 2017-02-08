@extends('layouts.admin.index')

@section('title','Reportes')

@section('content')

    <div class="row">
        <div class="col m6 col s12">
            <h5>
                Generar Credenciales
            </h5>
            @include('alert.success')
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.credenciales','method' => 'GET'])!!}

        <div class="input-field col s2 ">
           {!! Form::label('start','Desde:') !!}
           {!! Form::text('start',$start,['class'=>'validate', 'placeholder'=>'Registro Inicial', 'id'=>'start']) !!}
        </div>
        <div class="input-field col s2 ">
           {!! Form::label('end','Hasta:') !!}
           {!! Form::text('end',$end,['class'=>'validate', 'placeholder'=>'Registro Final', 'id'=>'end']) !!}
        </div>

        <div class="col s1 offset-s8">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!!form::close()!!}

        {!! Form::open (['route' => 'admin.reports.export-credenciales','method' => 'GET'])!!}
            @include('campamentos.reportes.credenciales.export-credenciales')
        {!! Form::close() !!}
    </div>

    <hr>
    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Recibo</th>
                    <th>Alumno</th>
                    <th>Edad</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Horario</th>
                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                {{sprintf("%'.05d",$insc->id)}}
                            </td>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->getNombreAttribute() }}
                                @else
                                    {{ $insc->alumno->persona->getNombreAttribute() }}
                                @endif
                            </td>
                            {{--<td>--}}
                                {{--@if ($insc->alumno_id==0)--}}
                                    {{--{{ $insc->factura->representante->persona->num_doc  }}--}}
                                {{--@else--}}
                                    {{--{{$insc->alumno['persona']['num_doc']}}--}}
                                {{--@endif--}}
                            {{--</td>--}}
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{$insc->factura->representante->getEdad($insc->factura->representante->persona->fecha_nac)}}
                                @else
                                    {{$insc->alumno->getEdad($insc->alumno->persona->fecha_nac)}}
                                @endif
                            </td>
                            <td>{{ $insc->calendar->program->escenario->escenario }}</td>
                            <td>{{ $insc->calendar->program->disciplina->disciplina }}</td>
                            <td>
                                {{ $insc->calendar->dia->dia}} / {{ $insc->calendar->horario->start_time}}-{{ $insc->calendar->horario->end_time}}
                            </td>
                        </tr>
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
            {{ $inscripciones->appends(['start'=>$start,'end'=>$end])->links() }}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            $("#filtrar").on('click', function () {
                var exportar = $(".exportar");
                exportar.prop("disabled", false);
            });
        });

    </script>

@endsection
