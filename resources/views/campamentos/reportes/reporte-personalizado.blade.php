@extends('layouts.admin.index')

@section('title','Reportes')

@section('content')

    <div class="row">
        <div class="col l12 col m6 col s12">
            <h5>
                Generar Reporte Personalizado (filtre y luego exporte)
            </h5>
            @include('alert.success')
        </div>
    </div>

    <div class="row">
        {!! Form::open (['route' => 'admin.reports.personalizado','method' => 'GET', 'class'=>'form_datepicker', 'id'=>'form_data'])!!}

        <div class="input-field col s3 ">
            {{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo','required']) }}
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
        <div class="input-field col s3 ">
            {{Form::select('dia',$diaSelect,$dia,['id'=>'dia']) }}
        </div>
        {{--<div class="input-field col s3 ">--}}
            {{--{!! Form::select('sexo', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],'null', ['placeholder' => 'Sexo...','id'=>'sexo']) !!}--}}
        {{--</div>--}}

        {{--<div class="input-field col s2 ">--}}
            {{--{!! Form::label('start','Desde:') !!}--}}
            {{--{!! Form::date('start',$start,['class'=>'datepicker']) !!}--}}
        {{--</div>--}}
        {{--<div class="input-field col s2 ">--}}
            {{--{!! Form::label('end','Hasta:') !!}--}}
            {{--{!! Form::date('end',$end,['class'=>'datepicker']) !!}--}}
        {{--</div>--}}

        <div class="col s1 offset-s7">
            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar', 'type'=>'submit','id'=>'filtrar']) !!}
        </div>

        {{--<div class="col s1">--}}
            {{--{!! Form::button('<i class="fa fa-file-excel-o fa-2x" ></i>',['class'=>'exportar btn-floating waves-effect waves-light teal tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Exportar']) !!}--}}
        {{--</div>--}}

        {!!form::close()!!}

{{--        {!! Form::open (['route' => 'admin.reports.exportPersonalizado','method' => 'GET'])!!}--}}
            @include('campamentos.reportes.export-personalizado')
        {{--{!! Form::close() !!}--}}
    </div>

    <hr>
<div  id="preloader_export" class="center hidden">
    <div class="preloader-wrapper big">
        <div class="spinner-layer spinner-blue-only">
            <div class="circle-clipper left">
                <div class="circle"></div>
            </div>
            <div class="gap-patch">
                <div class="circle"></div>
            </div>
            <div class="circle-clipper right">
                <div class="circle"></div>
            </div>
        </div>
    </div>
</div>

    <div class="row">
        {{--<div class="col l12">--}}
            {{--<div class="table-responsive">--}}
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Alumno App</th>
                            <th>Alumno Nomb</th>
                            <th>CI</th>
                            <th>Modulo</th>
                            <th>Escenario</th>
                            <th>Disciplina</th>
                            <th>Días</th>
                            <th>Representante</th>
                            <th>Profesor</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Alumno App</th>
                            <th>Alumno Nomb</th>
                            <th>CI</th>
                            <th>Modulo</th>
                            <th>Escenario</th>
                            <th>Disciplina</th>
                            <th>Días</th>
                            <th>Representante</th>
                            <th>Profesor</th>
                        </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($inscripciones as $insc )
                        <tr>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->apellidos }}
                                @else
                                    {{ $insc->alumno }}
                                @endif
                            </td>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->nombres }}
                                @else
                                    {{--{{ $insc->alumno->persona->nombres }}--}}
                                @endif
                            </td>
                            <td>
                                @if ($insc->alumno_id==0)
                                    {{ $insc->factura->representante->persona->num_doc  }}
                                @else
                                    ci
                                    {{--{{$insc->alumno['persona']['num_doc']}}--}}
                                @endif
                            </td>
                            <td>{{$insc->calendar->program->modulo->modulo}}</td>
                            <td>{{ $insc->calendar['program']->escenario->escenario }}</td>
                            <td>{{ $insc->calendar['program']->disciplina->disciplina }}</td>
                            <td>{{ $insc->calendar->dia->dia }}</td>
{{--                            <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>--}}
                            <td>{{ $insc->calendar->profesor->getNameAttribute() }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
            {{ $inscripciones->appends(['modulo'=>$modulo,'escenario'=>$escenario,'disciplina'=>$disciplina,
         'horario'=>$horario,'entrenador'=>$entrenador,'dia'=>$dia])->links()}}
        {{--</div><!--end div ./col-lg-12. etc-->--}}
    {{--</div><!--end div ./row-->--}}

@endsection

@section('scripts')

    <script>
        $(document).ready(function () {

           $(".exportar2").on('click',function (event) {
               event.preventDefault();
               $(".exportar").prop('disabled', true);
               $("#preloader_export").removeClass('hidden');
               var escenario_id=$("#escenario").val();
               var modulo_id=$("#modulo").val();
               var disciplina_id=$("#disciplina").val();
               var horario_id=$("#horario").val();
               var entrenador_id=$("#entrenador").val();
               var dia_id=$("#dia").val();
               var datos={
                   escenario:escenario_id,
                   modulo:modulo_id,
                   disciplina:disciplina_id,
                   horario:horario_id,
                   entrenador:entrenador_id,
                   dia:dia_id
               }
               var token = $("input[name=_token]").val();
               var route="{{route('admin.reports.exportPersonalizado')}}";

               $.ajax({
                   url: route,
                   data: datos,
                   type: "GET",
                   headers: {'X-CSRF-TOKEN': token},
//                   success: function(response){
//                       console.log(response);
//                     location.href = response.responseJSON;
//                   },
//                   contentType: 'application/x-www-form-urlencoded',
                   complete:function (res) {
                     console.log(res);
                       $(".exportar").prop('disabled', false);
                       $("#preloader_export").addClass('hidden');
                   }
//                   success: function (resp) {
//                       console.log(resp);
//                       $(".exportar").prop('disabled', false);
//                       $("#preloader_export").addClass('hidden');
//                   },
//                   error: function (resp) {
//                       console.log(resp);
//
//                   }
               });
           })
        });


    </script>

@endsection



