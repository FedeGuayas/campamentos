@extends('layouts.admin.index')

@section('title','Reportes')

@section('content')

    <div class="row">
        <div class="col m6 col s12">
            <h5>
                Generar Credenciales
            </h5>
            @include('alert.success')
            {{--            @include('campamentos.reportes.credenciales.searchCredenciales')--}}
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.credenciales','method' => 'GET','role' => 'search','class'=>'form_datepicker'])!!}

        <div class="input-field col s2 ">
            {!! Form::label('start','Desde:') !!}
            {!! Form::date('start',$start,['class'=>'datepicker']) !!}
        </div>
        <div class="input-field col s2 ">
            {!! Form::label('end','Hasta:') !!}
            {!! Form::date('end',$end,['class'=>'datepicker']) !!}
        </div>

        <div class="input-field col s3 ">
            {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
        </div>

        <div class="input-field col s3 ">
            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
        </div>

        <div class="col s1">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>
        {!!form::close()!!}

        {{--@include('campamentos.reportes.credenciales.export-credenciales')--}}
    </div>

    <hr>
    <div class="row">
        <div class="col l12">
            <div class="table-responsive">
                {!! Form::open (['route' => 'admin.reports.export-credenciales','method' => 'GET', 'target'=>'_blank'])!!}
                {{--{!! Form::open(['route'=>'admin.users.setroles', 'method'=>'POST']) !!}--}}
                <table id="credenciales" class="display nowrap">
                    <thead>
                    <th>Recibo</th>
                    <th>Alumno</th>
                    <th>Edad</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Horario</th>
                    <th>
                        {!! Form::checkbox('imp_all',null,false,['id'=>'imp_all', 'class'=>'filled-in']) !!}
                        {!! Form::label('imp_all','Imp. Pag') !!}
                    </th>
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
                           {{-- <td>
                            @if ($insc->alumno_id==0)
                            {{ $insc->factura->representante->persona->num_doc  }}
                            @else
                            {{$insc->alumno['persona']['num_doc']}}
                            @endif
                            </td>--}}
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
                                {{ $insc->calendar->dia->dia}} / {{ $insc->calendar->horario->start_time}}
                               -{{ $insc->calendar->horario->end_time}}
                            </td>
                            <td>
                                <a href="">
                                    {!! Form::checkbox('imp_cred[]',$insc->id,false,['id'=>$insc->id]) !!}
                                    {!! Form::label($insc->id, $insc->id) !!}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </table><!--end table-responsive-->

                <div class="hidden">
                    {!! Form::date('start',$start,['class'=>'datepicker']) !!}
                    {!! Form::date('end',$end,['class'=>'datepicker']) !!}
                    {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}
                    {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}
                </div>
                <div class="col s1 right">
                    {!! Form::button('<i class="fa fa-file-pdf-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light orange darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar', 'type'=>'submit']) !!}
                </div>
                {!!form::close()!!}
                {{ $inscripciones->appends(['start'=>$start,'end'=>$end,'escenario'=>$escenario,'modulo'=>$modulo])->links() }}
            </div><!-- end div ./table-responsive-->

        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')

    <script>


        $("#imp_all").change(function () {
            $("input:checkbox").prop('checked', $(this).prop("checked"));
        });


        $(document).ready(function () {

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
