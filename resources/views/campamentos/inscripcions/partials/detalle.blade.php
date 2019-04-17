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
                            {{--<li><a href="{{route('inscripciones.restarUno',['id'=>$curso['curso']['id']])}}"><i--}}
                                            {{--class="fa fa-trash-o red-text"></i> Quitar 1</a></li>--}}
                            {{--<li class="divider"></li>--}}
                            <li><a href="{{route('inscripciones.restarTodo',['id'=>$curso['curso']['id']])}}">Quitar
                                    todos</a></li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="text-danger"> $ {{ number_format($precioTotal,2,'.',' ')}}</span></td>
            <td><span class="text-danger"> $ {{ number_format($matriculaTotal,2,'.',' ')}}</span></td>
            <td><span class="text-danger"> $ {{ number_format($subTotal,2,'.',' ')}}</span></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td>
            <td>DESCUENTO</td>
            <td> <input type="text" id="descuento_factura" hidden  value="{{$descuento}}">
                <span class="label label-success"> $ {{ number_format($descuento,2,'.',' ')}}</span></td>
            <td></td><td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td>
            <td>Conceptos: </td>
            <td colspan="5">
{{--                {{ $tipo_desc->porciento.'%'. $tipo_desc->descripcion }}--}}
{{--                {{$tipo_desc}}--}}
                @if(  $desc_emp == 'true' && !isset($tipo_desc))
                    50% Empleado
                @endif
                @if( isset($tipo_desc))
                    {{ $tipo_desc->porciento.'%'. $tipo_desc->descripcion }}
                @endif
                {{--@if($tipo_desc=='multiple')--}}
                    {{--10% Inscripción multiples meses--}}
                {{--@endif--}}
                {{--@if($tipo_desc=='empleado')--}}
                    {{--50% Empleado--}}
                {{--@endif--}}
                {{--@if($tipo_desc=='u_educativa')--}}
                    {{--20% Unidad Educativa--}}
                {{--@endif--}}
            </td>
            <td></td><td></td>
        </tr>
        <tr>
            <td></td><td></td><td></td><td></td><td></td>
            <td></td>
            <td>
            </td>
            <td>Total:</td>
            <td>
                <input type="text" id="total_factura" hidden  value="{{$total}}">
                <span class="text-primary"> ${{number_format($total,2,'.',' ')}}</span>
            </td>
        </tr>
        </tbody>

    </table>


@else
    <div class="row">
        <div class="col s6 col m6 offset-m3 offset-s3">
            <h2>No hay Cursos en la coleccion</h2>
        </div>
    </div>
@endif


