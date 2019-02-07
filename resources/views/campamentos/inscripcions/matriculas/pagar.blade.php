@extends('layouts.admin.index')

@section('title', 'Pagar matricula')

@section('content')

    {{--<div class="row">--}}
    <h5 class="header teal-text text-darken-2">Pagar matrícula de inscripción No. {{$inscripcion->id}}</h5>
    @include('alert.request')
    @include('alert.success')


    <div class="col s12">

        {{--            {!! Form::model($inscripcion,['route'=>['admin.inscripcions.postMatricula',$inscripcion->id], 'method'=>'POST'])  !!}--}}
        {!! Form::open(['id'=>'form_pagar_matricula'])  !!}
        {!! Form::hidden('inscripcion',$inscripcion->id) !!}
        <div class="row">

            <div class="col s12 m8 offset-m2">

                <div class="card large hoverable z-depth-5 sticky-action  wow fadeInUp" data-wow-delay="0.3s">
                    <div class="card-image waves-effect waves-block waves-light">
                        @if($inscripcion->calendar->program->imagen)
                            <img class="activator"
                                 src="{{ asset('/img/camp/disciplinas/'.$inscripcion->calendar->program->imagen)}}"
                                 style="max-height: 300px;">
                        @else
                            <img class="activator" src="{{ asset('/img/camp/fdg-logo.png')}}">
                        @endif
                    </div>
                    <div class="card-content">
                    <span class="card-title activator grey-text text-darken-4">Más información<i
                                class="material-icons right">more_vert</i></span>
                        <p>
                            No. Registro: {{$inscripcion->id}} <br>
                            No. Comprobante: {{$inscripcion->factura->id}} <br>
                            Mensualidad cancelada: $ {{number_format($inscripcion->factura->total,2,'.',' ')}}
                        </p>
                    </div>

                    <div class="card-action">
                        <div class="row">
                            <div class="col s12">

                                <div class="col m4">
                                    {!! Form::select('fpago_id',$fpagos,null, ['class'=>'browser-default form-control','placeholder'=>'F. Pago'], ['id'=>'fpago_id']) !!}
                                </div>


                                <a href="#" id="pagar_matricula"
                                   class="btn light-blue lighten-1 waves-effect waves-light tooltipped left" data-position="top"
                                   data-tooltip="Pagar">
                                    <span class="price">$ {{number_format($inscripcion->calendar->program->matricula,2,'.',' ')}}</span>
                                </a>


                                <a href="{{route('admin.inscripcions.index')}}" id="regresar"
                                   class="btn waves-effect waves-light red lighten-1 right">
                                    Regresar
                                </a>

                            </div>
                        </div>
                        <div class="loader hide center">
                            <span class="text-danger">Espere...</span>
                            <div class="preloader-wrapper small">
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

                    </div>
                    <div class="card-reveal">
                    <span class="card-title grey-text text-darken-4">
                        Cerra Información:
                        <i class="material-icons right">close</i></span>
                        <ul class="collection">
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Representante">
                                {{$inscripcion->factura->representante->persona->getNombreAttribute()}}

                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Alumno">
                                @if ($inscripcion->alumno_id == 0)
                                    {{$inscripcion->factura->representante->persona->getNombreAttribute()}}
                                @else
                                    {{$inscripcion->alumno->persona->getNombreAttribute()}}
                                @endif
                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Módulo">
                                {{$inscripcion->calendar->program->modulo->modulo}}
                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Escenario">
                                {{$inscripcion->calendar->program->escenario->escenario}}
                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Disciplina">
                                {{$inscripcion->calendar->program->disciplina->disciplina}}
                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Días">
                                {{$inscripcion->calendar->dia->dia}}
                            </li>
                            <li class="collection-item tooltipped" data-position="right" data-delay="50"
                                data-tooltip="Horarios">
                                {{$inscripcion->calendar->horario->start_time.' - '.$inscripcion->calendar->horario->end_time}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
        {!! Form::close() !!}

    </div>





    {{--</div><!--/.row-->--}}






@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(".form_noEnter").keypress(function (e) {
                if (e.width === 13) {
                    return false;
                }
            });

            $("#pagar_matricula").on("click", function (event) {
                event.preventDefault();
                var form = $("#form_pagar_matricula");
                var data = form.serialize();
                $("#pagar_matricula").hide();
                $("#regresar").addClass('disabled');
                $(".loader").removeClass('hide');
                $(".preloader-wrapper").addClass('active');

                var route = "{{route('admin.inscripcions.postMatricula')}}";
                var token = $("input[name=_token]").val();

                $.ajax({
                    url: route,
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': token},
                    data: data,
                    cache: false,
                    processData: false,
                    success: function (resp) {
                        if (resp.status === 409) {
                            swal("", resp.responseJSON.message, "error");
                        }
                        swal("", 'Se realizo el pago correctamente. Imprima el comprobante.', "success");
                        $("#pagar_matricula").show();
                        $(".loader").addClass('hide');
                        $(".preloader-wrapper").removeClass('active');
                        $("#regresar").removeClass('disabled');
                        $(".sa-confirm-button-container .confirm").on('click', function () {

                            window.setTimeout(function () {
//                                    location.reload()
                                location.href = "{{route('admin.pago_matriculas.index')}}";
                            }, 1)
                        });

                    },
                    error: function (resp) {
                        if (resp.status === 409) {
//                            console.log(resp.responseJSON.message);
                            swal("", resp.responseJSON.message, "error");
                            $("#pagar_matricula").show();
                            $(".loader").addClass('hide');
                            $(".preloader-wrapper").removeClass('active');
                            $("#regresar").removeClass('disabled');
                        }
                    }
                });

            });

            $("#form_pagar_matricula").submit(function (e) {
                e.preventDefault();

            });
        });
    </script>
@endsection