<div id="modal-representante" class="modal modal-fixed-footer" style="width: 70%;">
    {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_representante']) !!}
    <div class="modal-content">

        {{--    {!! Form::open(['route'=>'admin.representantes.store', 'method'=>'POST','files'=>'true'])  !!}--}}
        <div class="row">
            <div class="col m3 s12">
                <h6 class="teal-text text-darken-2">Crear Representante</h6>
            </div>
        </div>

        <div class="row">
            <div class="input-field col m3 s12 ">
                <i class="fa fa-user prefix"></i>
                {!! Form::label('nombres','Nombres: *') !!}
                {!! Form::text('nombres',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
            </div>
            <div class="input-field col m3 s12">
                {!! Form::label('apellidos','Apellidos: *') !!}
                {!! Form::text('apellidos',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
            </div>
            <div class="input-field col m3 s12">
                {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null,['id'=>'genero']) !!}
                {!! Form::label('genero','Género: *') !!}
            </div>
            <div class="form-group col m3 s12">
                {!! Form::label('fecha_nac','Fecha de Nacimiento: *',['class'=>'label-control']) !!}
                {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
            </div>
        </div>

        <div class="row">
            <div class="input-field col m3 s12">
                {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null,['id'=>'tipo_doc']) !!}
                {!! Form::label('tipo_doc', 'Tipo doc: *') !!}
            </div>
            <div class="input-field col m3 4 s12">
                {!! Form::label('num_doc','Número del documento: *') !!}
                {!! Form::text('num_doc',null,['class'=>'validate','required','onkeypress'=>"if (this.value.length > 9) {return false}"]) !!}
            </div>
            <div class="input-field col  m4 s12">
                <i class="fa fa-envelope prefix"></i>
                {!! Form::label('email','Correo: *') !!}
                {!! Form::email('email',null,['class'=>'validate']) !!}
            </div>
        </div>

        <div class="row">
            <div class="input-field col m3 s6">
                <i class="fa fa-phone prefix"></i>
                {!! Form::text('telefono',null,['class'=>'validate','id'=>'telefono']) !!}
                {!! Form::label('telefono','Teléfono1: *') !!}
            </div>
            <div class="input-field  col m3 s6">
                <i class="fa fa-phone prefix"></i>
                {!! Form::text('phone',null,['class'=>'validate','id'=>'phone']) !!}
                {!! Form::label('phone','Teléfono2:') !!}
            </div>
            <div class="input-field  col m4 s12">
                <i class="fa fa-pencil prefix"></i>
                {!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255','style'=>'text-transform:uppercase']) !!}
                {!! Form::label('direccion','Dirección: *') !!}
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
               data-position="top" delay="50" data-tooltip="Guardar" id='representante_create'>
                <i class=" fa fa-save" aria-hidden="true"></i>
            </a>
            {!! Form::button('<i class="fa fa-paint-brush" aria-hidden="true"></i>',['class'=>'btn white-text orange darken-1 waves-effect waves-light tooltipped', 'data-position'=>'top', 'delay'=>'50', 'data-tooltip'=>'Limpiar','type' => 'reset']) !!}
            {!! Form::button('<i class="fa fa-close" aria-hidden="true"></i>',['class'=>'btn white-text red darken-1 modal-action modal-close waves-effect waves-light tooltipped', 'data-position'=>'top', 'delay'=>'50','data-tooltip'=>'Cerrar']) !!}
        </div>
    </div>
    {!! Form::close() !!}
</div>





