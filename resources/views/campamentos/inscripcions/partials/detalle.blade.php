@if (Session::has('curso'))

    <hr>

    <table class="table table-striped table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
        <thead>
        <tr>
            <td>Escenario</td>
            <td>Disciplina</td>
            <td>Modulo</td>
            <td>Alumno</td>
            <td>Costo</td>
            <td style="text-align: center">U</td>
            <td>Costo/U</td>
            <td>Matricula</td>
            <td>SubTotal</td>
            <td>Accion</td>
        </tr>
        </thead>
        <tbody>
        @foreach($cursos as $curso)
            <tr>
                <td>{{$curso['curso']['program']['escenario']['escenario']}}</td>
                <td>{{$curso['curso']['program']['disciplina']['disciplina']}}</td>
                <td> {{$curso['curso']['program']['modulo']['modulo']}}</td>
                <td>
                    @foreach($curso['alumno'] as $alumno)
                        {{$alumno['persona']['nombres'].' ' . $alumno['persona']['apellidos']}}<br>
                    @endforeach
                </td>
                <td> $ {{ number_format($curso['curso']['mensualidad'],2,'.',' ')}}</td>
                <td style="text-align: center">{{$curso['qty']}}</td>
                <td>$ {{ number_format((($curso['curso']['mensualidad'])* $curso['qty']),2,'.',' ')}}</td>
                <td>$ {{number_format($curso['matricula'],2,'.',' ')}}</td>
                <td>
                    $ {{  number_format( (($curso['curso']['mensualidad'])* $curso['qty'])+$curso['matricula'])}}
                </td>
                <td>
                    <div class="btn-group">
                        <button type="button" data-toggle="dropdown"
                                class="btn-xs waves-effect waves-light dropdown-toggle">Eliminar <span
                                    class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a href="{{route('inscripciones.restarUno',['id'=>$curso['curso']['id']])}}"><i
                                            class="fa fa-trash-o red-text"></i> Quitar 1</a></li>
                            <li class="divider"></li>
                            <li><a href="{{route('inscripciones.restarTodo',['id'=>$curso['curso']['id']])}}">Quitar
                                    todos</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td><td></td><td></td><td></td><td></td>
            <td>DESCUENTO</td>
            <td><span class="label label-warning"> $ {{ number_format($descuento,2,'.',' ')}}</span></td>
            <td></td><td></td>
        </tr>
        </tbody>

    </table>

    <div class="row">
        <div class="col l8 pull-right">

            <div class="row">
                <div class="col l3">
                    <h5>SubTotal: </h5>
                </div>
                <div class="col l9">
                    <h5><span class="label label-success"> $ {{ number_format($subTotal,2,'.',' ')}}</span></h5>
                </div>
            </div>

            <div class="row">
                <div class="col l3">
                    <h5>Descuento:</h5>
                </div>
                <div class="col l9">
                    <h5><span class="label label-warning"> $ {{ number_format($descuento,2,'.',' ')}}</span></h5>
                </div>
            </div>

            <div class="row">
                <div class="col l3">
                    <h5>Conceptos:</h5>
                </div>
                <div class="col l9">
                    <h5>
                        @if($tipo_desc=='familiar')
                            10% Inscripción Familiar
                        @endif
                        @if($tipo_desc=='multiple')
                            10% Inscripción multiples meses
                        @endif
                        @if($tipo_desc=='empleado')
                            50% Empleado
                        @endif
                    </h5>

                </div>

            </div>

            <div class="row">
                <div class="col l3">
                    <h5>Total: </h5>
                </div>
                <div class="col l9">
                    <h5>
                        <span class="label label-primary"> ${{number_format($total,2,'.',' ')}}</span>
                    </h5>
                </div>
            </div>
        </div>
    </div>


@else
    <div class="row">
        <div class="col s6 col m6 offset-m3 offset-s3">
            <h2>No hay Cursos en la coleccion</h2>
        </div>
    </div>
@endif


