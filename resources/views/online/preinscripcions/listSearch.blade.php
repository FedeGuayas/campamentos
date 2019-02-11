<table class="table table-striped table-bordered table-condensed table-hover highlight " id="table_search">
    <thead>
        <th hidden>Id</th>
        <th>Nombres y Apellidos</th>
        <th>Identificación</th>
        <th>Género</th>
        <th>Seleccionar</th>

    </thead>
        @foreach ($representantes as $per)
        <tr>
            <td hidden>{{ $per->id }}</td> {{--ID de Persona--}}
            <td>{{ $per->getNombreAttribute() }}</td>
            <td>{{ $per->num_doc }}</td>
            <td>{{$per->genero}}
            <td>
                {!! Form::checkbox($per->id,$per->id,null,['id'=>$per->id]) !!}
                {!! Form::label($per->id, 'Agregar') !!}
            </td>
        </tr>
        @endforeach
</table><!--end table-responsive-->
