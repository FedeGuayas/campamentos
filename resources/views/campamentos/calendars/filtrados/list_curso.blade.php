{{--Resultado de la busquedad del curso para editar la inscripcion--}}
<h5>Cambiar a:</h5>
<table>
    <thead>
    <tr>
        <th>id</th>
        <th>Dias</th>
        <th>Horario</th>
        <th>Edades</th>
        <th>Costo</th>
        <th>Cupos</th>
        <th>Inscritos</th>
        <th>Disponible</th>
        <th>Cambiar</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($cursos as $curso)
        <tr>
            <td>{{ $curso->id }}</td>
            <td>{{ $curso->dia->dia}}</td>
            <td>{{ $curso->horario->start_time.'-'.$curso->horario->end_time}}</td>
            <td>{{ $curso->init_age.'-'.$curso->end_age}}</td>
            <td>$ {{number_format($curso->mensualidad,2,'.',' ') }}</td>
            <td>{{ $curso->cupos}}</td>
            <td>{{ $curso->contador}}</td>
            <td>
                @if( ($curso->cupos - $curso->contador) <=1)
                    <span class="label label-danger">{{ $curso->cupos - $curso->contador }}</span>

                @elseif(($curso->cupos - $curso->contador) <= ($curso->cupos)/3)
                    <span class="label label-success">{{ $curso->cupos - $curso->contador }}</span>

                @elseif(($curso->cupos - $curso->contador) >= ($curso->cupos)/3)
                    <span class="label blue">{{ $curso->cupos - $curso->contador }}</span>
                @else
                    {{ $curso->cupos - $curso->contador }}
                @endif
            </td>
            <td>
                @if ( (($curso->cupos - $curso->contador)>0) && ($costo == $curso->mensualidad) && ($edad>=$curso->init_age && $edad<=$curso->end_age) && (Auth::user()->hasRole(['planner','administrator','supervisor'])))
                    <a href="{{ route('admin.inscripcions.curso.update', [$inscripcion_id,$curso ] ) }}">
                        {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'label  waves-effect waves-light teal darken-1']) !!}
                    </a>
                @endif
            </td>
        </tr>
    @endforeach
    </tbody>
</table><!--end table-responsive-->
