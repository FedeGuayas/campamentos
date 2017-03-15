<div class="col l12">
    <div class="row">

        <div class="card-panel">
            {{--<h5 class="header teal-text text-darken-2">Calendario:</h5>--}}
            <div class="card-content ">
                {{--Curso anterior--}}
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title ">Curso Anterior</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                            <thead>
                            <th>Alumno</th>
                            <th>Edad</th>
                            <th>Escenario</th>
                            <th>Disciplina</th>
                            <th>Modulo</th>
                            <th>Dias</th>
                            <th>Horarios</th>
                            <th>Familiar</th>
                            <th>Pago</th>
                            {{--<th>Mensualidad</th>--}}
                            <th>Factura</th>
                            </thead>
                            <tr>
                                <td>
                                    @if ($inscripcion->alumno_id==0)
                                        {{$inscripcion->factura->representante->persona->getNombreAttribute()}}
                                    @else
                                        {{$inscripcion->alumno->persona->getNombreAttribute()}}
                                    @endif
                                </td>
                                <td>{{$edad}}</td>
                                <td>{{$inscripcion->calendar->program->escenario->escenario}}</td>
                                <td>{{$inscripcion->calendar->program->disciplina->disciplina}}</td>
                                <td>{{$inscripcion->calendar->program->modulo->modulo}}</td>
                                <td>{{$inscripcion->calendar->dia->dia}}</td>
                                <td>{{$inscripcion->calendar->horario->start_time}}-{{ $inscripcion->calendar->horario->end_time}}</td>
                                {{--<td>${{number_format($costo_actual,2,'.',' ')}}</td>--}}
                                <td>
                                    @if ($count_fact ==1)
                                        <p class="label label-success">NO</p>
                                        @else
                                        <p class="label label-danger">SI</p>
                                    @endif
                                </td>
                                <td><p class="label label-success">{{$inscripcion->factura->pago->forma}}</p></td>
                                <td>${{number_format($inscripcion->factura->total,2,'.',' ')}}</td>

                            </tr>
                        </table>
                    </div>
                </div>

                {{--Curso al k se va a inscribir--}}
                @if (count($curso_nuevo)>0 && $count_fact ==1)
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title ">Inscribir</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                            <thead>
                            <th>Alumno</th>
                            <th>Edad</th>
                            <th>Escenario</th>
                            <th>Disciplina</th>
                            <th>Modulo</th>
                            <th>Dias</th>
                            <th>Horarios</th>
                            <th>Costo</th>
                            </thead>
                            <tr>
                                <td>
                                    @if ($inscripcion->alumno_id==0)
                                        {{$inscripcion->factura->representante->persona->getNombreAttribute()}}
                                    @else
                                        {{$inscripcion->alumno->persona->getNombreAttribute()}}
                                    @endif
                                </td>
                                <td>{{$edad}}</td>
                                <td>{{$curso_nuevo->program->escenario->escenario}}</td>
                                <td>{{$curso_nuevo->program->disciplina->disciplina}}</td>
                                <td>{{$curso_nuevo->program->modulo->modulo}}</td>
                                <td>{{$curso_nuevo->dia->dia}}</td>
                                <td>{{$curso_nuevo->horario->start_time}}-{{ $curso_nuevo->horario->end_time}}</td>
                                </td>
                                <td>${{number_format($inscripcion->factura->total,2,'.',' ')}}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                    <div class="row">
                        {!! Form::open(['route'=>'admin.re_inscripcions.curso.store', 'method'=>'POST', 'class'=>'form_noEnter', 'id'=>'form_re-inscripcion'])  !!}
                        {!! Form::hidden('calendar_id',$curso_nuevo->id,['id'=>'calendar_id']) !!}
                        {!! Form::hidden('inscripcion_id',$inscripcion->id,['id'=>'inscripcion_id']) !!}

                        <div class="col s1 right">
                            {{--<a href="#!" id="inscribir">--}}
                                {!! Form::button('<i class="fa fa-arrow-circle-right left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Inscribir', 'type'=>'submit']) !!}
                            {{--</a>--}}
                        </div>
                        {!! Form::close() !!}
                    </div>

                @else

                    <h5 class="red-text">No existe este curso para el presente mes!!! O es una inscripción familiar y debe realizarla normalmente</h5>
                @endif

            </div><!--/.card content-->

        </div>

    </div>

</div>
