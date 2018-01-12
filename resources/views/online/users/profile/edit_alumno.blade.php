<div id="modal-edit-alumno-{{$alumno->id}}" class="modal hoverable">
    <div class="modal-body">
        <div class="row">
            <div class="col s12">

                {!! Form::model($alumno,['route'=>['user.alumno.update',$alumno->id], 'method'=>'PUT', 'files'=>'true']) !!}

                <h5 class="header teal-text text-darken-2">Editar alumno</h5>

                <div class="row">
                    <div class="input-field col l6 m6 s12 ">
                        <i class="fa fa-user prefix"></i>
                        {!! Form::label('nombres','Nombres:*') !!}
                        {!! Form::text('nombres',$alumno->persona->nombres,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                    </div>
                    <div class="input-field col l6  m6 s12">
                        {!! Form::label('apellidos','Apellidos:*') !!}
                        {!! Form::text('apellidos',$alumno->persona->apellidos,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col l4 m4 s12">
                        {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                        {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],$alumno->persona->tipo_doc, ['id'=>'tipo_doc','class'=>'browser-default','placeholder'=>'Seleccione...','required']) !!}
                    </div>
                    <div class="input-field col l4 m4 s12">
                        {!! Form::label('num_doc','Número:*') !!}
                        {!! Form::text('num_doc',$alumno->persona->num_doc,['class'=>'validate','required']) !!}
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col l4 m4 s12">
                        {!! Form::label('genero','Género:8') !!}
                        {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],$alumno->persona->genero, ['id'=>'genero','required','class'=>'browser-default','placeholder'=>'Seleccione']) !!}
                    </div>
                    <div class="form-group col l4 m4 s12">
                        {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                        {{  Form::date('fecha_nac',$alumno->persona->fecha_nac,[ 'class'=>'validate','required']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="file-field input-field  col l3 m6 s6">
                        @if (($alumno->foto_ced)!="")
                            <i class="fa  fa-2x fa-image prefix" aria-hidden="true"></i>
                            {!! Form::text('foto_ced',$alumno->foto_ced,['class'=>'file-path validate']) !!}
                            {!! Form::file('foto_ced') !!}
                            {!! Form::hidden('foto_ced',$alumno->foto_ced,['id'=>'foto_ced']) !!}
                            <img src="{{ asset('dist/img/alumnos/cedula/'.$alumno->foto_ced)}}" style='max-width: 100px' class="img-thumbnail">
                        @else
                            <i class="fa  fa-2x fa-image prefix" aria-hidden="true"></i>
                            {!! Form::text('foto_ced','Fotocopia Cedula*',['class'=>'file-path validate']) !!}
                            {!! Form::file('foto_ced',['required']) !!}
                        @endif

                    </div>
                    <div class="file-field input-field  col l3 m6 s6">
                        @if (($alumno->foto)!="")
                            <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                            {!! Form::text('foto',$alumno->foto,['class'=>'file-path validate']) !!}
                            {!! Form::file('foto') !!}
                            {!! Form::hidden('foto',$alumno->foto,['id'=>'foto']) !!}
                            <img src="{{ asset('dist/img/alumnos/perfil/'.$alumno->foto)}}" style='max-width: 100px' class="img-thumbnail">
                        @else
                            <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                            {!! Form::text('foto','Foto Carnet*',['class'=>'file-path validate']) !!}
                            {!! Form::file('foto',['required']) !!}
                        @endif
                    </div>

                    <div class="col l6 m6 s12 center-align">
                        {!! Form::button('<i class="fa fa-pencil-square-o "></i>', ['class'=>'btn waves-effect waves-light tooltipped blue darken-1', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Actualizar','type' => 'submit']) !!}
                        {!! Form::button('<i class="fa fa-eraser"></i>',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}
                        {!! Form::button('<i class="fa fa fa-close"></i>', ['class'=>'btn modal-close waves-effect waves-light tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cerrar']) !!}
                    </div>
                </div>
                {!! Form::close() !!}

            </div>
        </div>
    </div><!--/.modal-body-->
</div><!--/.modal-->








