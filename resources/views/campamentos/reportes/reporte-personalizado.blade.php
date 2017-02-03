@extends('layouts.admin.index')

@section('title','Reportes')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h3>
                Generar Reporte Personalizado
            </h3>
            @include('alert.success')
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.personalizado','method' => 'GET', 'class'=>'form_datepicker' ])!!}

        <div class="input-field col s3 ">
            {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
        </div>
        <div class="input-field col s3 ">
            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
        </div>

        <div class="input-field col s3 ">
            {{Form::select('disciplina',$disciplinaSelect,$disciplina,['id'=>'disciplina']) }}
        </div>
        <div class="input-field col s3 ">
            {{Form::select('horario',$horarioSelect,$horario,['id'=>'horario']) }}
        </div>
        <div class="input-field col s3 ">
            {{Form::select('entrenador',$entrenadorSelect,$entrenador,['id'=>'entrenador']) }}
        </div>
        {{--<div class="input-field col s3 ">--}}
            {{--{!! Form::select('sexo', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],'null', ['placeholder' => 'Sexo...','id'=>'sexo']) !!}--}}
        {{--</div>--}}


        <div class="input-field col s2 ">
            {!! Form::label('start','Desde:') !!}
            {!! Form::date('start',$start,['class'=>'datepicker']) !!}
        </div>
        <div class="input-field col s2 ">
            {!! Form::label('end','Hasta:') !!}
            {!! Form::date('end',$end,['class'=>'datepicker']) !!}
        </div>

        <div class="col s3">

            {!! Form::button('Filtrar <i class="fa fa-search left"></i>',['class'=>'btn', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!!form::close()!!}

        {!! Form::open (['route' => 'admin.reports.exportPersonalizado','method' => 'GET'])!!}
        <div class="col s3">
            @include('campamentos.reportes.export-personalizado')
        </div>

        {!! Form::close() !!}
    </div>

    <hr>
    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                    <th>Recibo</th>
                    <th>Alumno App</th>
                    <th>Alumno Nomb</th>
                    <th>CI</th>
                    <th>Modulo</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Representante</th>
                    <th>Profesor</th>
                    </thead>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                {{sprintf("%'.05d",$insc->id)}}
                            </td>
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
                            <td>{{ $insc->calendar->profesor->getNameAttribute() }}</td>
                        </tr>
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
            {{ $inscripciones->appends(['modulo'=>$modulo,'escenario'=>$escenario,'start'=>$start,'end'=>$end,'disciplina'=>$disciplina,
            'horario'=>$horario,'entrenador'=>$entrenador])->links() }}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

            //valida el datepicker k no este vacio
            function checkDate() {

                if ($('.datepicker').val() == '') {
                    $('.datepicker').addClass('invalid')
                    $flag = 0;
                } else {
                    $('.datepicker').removeClass('invalid')
                    $flag = 1;
                }
            }

            $('.datepicker').change(function () {
                checkDate();
            });

            $('.form_datepicker').submit(function () {
                checkDate();
                if ($flag == 0) {
                    return false;
                } else {
                    return true;
                }
            });


            $('.datepicker').pickadate({
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 5, // Creates a dropdown of 15 years to control year
                format: 'yyyy/mm/dd'
            });

        });

        $(document).ready(function () {
            $("#filtrar").on('click', function () {
                var exportar = $(".exportar");

                exportar.prop("disabled", false);
            });

        });

    </script>

@endsection
