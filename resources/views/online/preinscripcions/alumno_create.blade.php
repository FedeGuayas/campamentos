<div id="modal-alumno" class="modal" style="width: 70%;">
    <div class="modal-content">
        {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_alumno']) !!}
        <div class="row">
            <div class="col m3 s12">
                <h5 class="teal-text text-darken-2">Crear Alumno</h5>
            </div>
        </div>

        <div class="row">
            <div class="row">
                <div class="input-field col m4 s12 ">
                    <i class="fa fa-user prefix"></i>
                    {!! Form::label('nombres_a','Nombres:*') !!}
                    {!! Form::text('nombres_a',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>
                <div class="input-field col m4 s12">
                    {!! Form::label('apellidos_a','Apellidos:*') !!}
                    {!! Form::text('apellidos_a',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>
                <div class="input-field col m3 s12">
                    {!! Form::select('genero_a', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null, ['id'=>'genero_a']) !!}
                    {!! Form::label('genero_a','Género:') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="input-field col m4 s12">
                {!! Form::select('tipo_doc_a', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null, ['id'=>'tipo_doc_a']) !!}
                {!! Form::label('tipo_doc_a', 'Tipo doc: *') !!}
            </div>
            <div class="input-field col m4 4 s12">
                {!! Form::label('num_doc_a','Núm. del documento: *') !!}
                {!! Form::text('num_doc_a',null,['class'=>'validate','required','onkeypress'=>"if (this.value.length > 9) {return false}"]) !!}
            </div>
            <div class="form-group col m3 s12">
                {!! Form::label('fecha_nac_a','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                {{  Form::date('fecha_nac_a',null,[ 'class'=>'validate','required']) }}
            </div>
        </div>

        <div class="row">
            <div class="col m6 s12">
                <div class="file-field input-field  col m6 s12">
                    <div class="btn">
                        <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                        {!! Form::file('foto_ced') !!}
                    </div>
                    <div class="file-path-wrapper">
                        {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                    </div>
                </div>
                <div class="file-field input-field  col m6 s12">
                    <div class="btn">
                        <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                        {!! Form::file('foto') !!}
                    </div>
                    <div class="file-path-wrapper">
                        {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto-Carne']) !!}
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="modal-footer">
        <div class="col m6 s12">
            <a href="#" class="btn white-text blue darken-1 waves-effect waves-light tooltipped"
               data-position="top" delay="50" data-tooltip="Guardar" id='alumno_create'>
                <i class=" fa fa-save" aria-hidden="true"></i>
            </a>
            {!! Form::button('<i class="fa fa-paint-brush" aria-hidden="true"></i>',['class'=>'btn white-text orange darken-1 waves-effect waves-light tooltipped', 'data-position'=>'top', 'delay'=>'50', 'data-tooltip'=>'Limpiar','type' => 'reset']) !!}
            {!! Form::button('<i class="fa fa-close" aria-hidden="true"></i>',['class'=>'btn white-text red darken-1 modal-action modal-close waves-effect waves-light tooltipped', 'data-position'=>'top', 'delay'=>'50','data-tooltip'=>'Cerrar']) !!}
        </div>
    </div>

</div>
