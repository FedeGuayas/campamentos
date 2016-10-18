<table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
    <thead>
        <th>Id</th>
        <th>Nombres y Apellidos</th>
        <th>Identificación</th>
        <th>Género</th>
        <th>Seleccionar</th>
    </thead>
        @foreach ($representantes as $per)
        <tr>
            <td>{{ $per->id }}</td>
            <td>{{ $per->getNombreAttribute() }}</td>
            <td>{{ $per->num_doc }}</td>
            <td>{{ $per->genero }}</td>
            <td>
                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$al->id"]) !!}
                <a href="{{ route('admin.alumnos.edit', $al->id ) }}">
                {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                </a>
                <a href="{{ route('admin.alumnos.show', $al->id ) }}">
                {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                </a>
            </td>
        </tr>
        @endforeach
</table><!--end table-responsive-->
