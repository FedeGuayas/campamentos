<div id="modal-representante" class="modal" style="width: 80%; height: 80%; overflow:auto !important;">
    <div class="container-fluid">
        <div class="col s12">

            <h5 class="teal-text text-darken-2">Crear Representante</h5>
            {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_representante']) !!}
            {{--    {!! Form::open(['route'=>'admin.representantes.store', 'method'=>'POST','files'=>'true'])  !!}--}}

            <div id="mensaje-rep-success" class="alert alert-success alert-dismissible" role="alert"
                 style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-labelledby="Cerrar"><span
                            aria-hidden="true">&times;</span></button>
                <li><strong id="msj-rep-succes"></strong></li>
            </div>
            <div id="mensaje-rep-error" class="alert alert-danger alert-dismissible" role="alert"
                 style="display: none">
                <button type="button" class="close" data-dismiss="alert" aria-labelledby="Close"><span
                            aria-hidden="true">&times;</span></button>
                <ul>
                    <li><strong id="msj-rep-error"></strong></li>
                </ul>
            </div>

            <div class="row">
                <div class="input-field col m4 s12">
                    <i class="fa fa-user prefix"></i>
                    {!! Form::label('nombres','Nombres:*') !!}
                    {!! Form::text('nombres',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>
                <div class="input-field col m4 s12">
                    {!! Form::label('apellidos','Apellidos:*') !!}
                    {!! Form::text('apellidos',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>

                <div class="input-field col m2 s12">
                    {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null,['id'=>'tipo_doc']) !!}
                    {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                </div>
                <div class="input-field col m2 s12">
                    {!! Form::label('num_doc','Número del documento:*') !!}
                    {!! Form::text('num_doc',null,['class'=>'validate','required','onkeypress'=>"if (this.value.length > 9) {return false}"]) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col m2 s12">
                    {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                    {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
                </div>
                <div class="input-field col m2 s12">
                    {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null,['id'=>'genero']) !!}
                    {!! Form::label('genero','Género:') !!}
                </div>

                <div class="input-field col m4 s12">
                    <i class="fa fa-envelope prefix"></i>
                    {!! Form::label('email','Correo:*') !!}
                    {!! Form::email('email',null,['class'=>'validate']) !!}
                </div>
                <div class="input-field  col m2 s12">
                    <i class="fa fa-phone prefix"></i>
                    {!! Form::text('telefono',null,['class'=>'validate','id'=>'telefono']) !!}
                    {!! Form::label('telefono','Teléfono1:*') !!}
                </div>
                <div class="input-field  col m2 s12">
                    <i class="fa fa-phone prefix"></i>
                    {!! Form::text('phone',null,['class'=>'validate','id'=>'phone']) !!}
                    {!! Form::label('phone','Teléfono2:') !!}
                </div>

            </div>

            <div class="row">
                <div class="input-field col m2 s12">
                    {!! Form::select('provincia_id',$list_provincias,null,['placeholder'=>'Seleccione provincia...','title'=>'Seleccione la provincia','id'=>'provincia_id']) !!}
                    {!! Form::label('provincia_id','Provincia:') !!}
                </div>
                <div class="input-field col m2 s12">
                    {!! Form::select('canton_id',[],null,['placeholder'=>'Seleccione el cantón','title'=>'Seleccione el cantón','id'=>'canton_id']) !!}
                    {!! Form::label('canton_id','Canton:') !!}
                </div>
                <div class="input-field col m2 s12">
                    {!! Form::select('parroquia_id',[],null,['placeholder'=>'Seleccione la parroquia','title'=>'Seleccione la parroquia','id'=>'parroquia_id']) !!}
                    {!! Form::label('parroquia_id','Parroquia:') !!}
                </div>
                <div class="input-field  col m6 s12">
                    <i class="fa fa-pencil prefix"></i>
                    {!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255','style'=>'text-transform:uppercase']) !!}
                    {!! Form::label('direccion','Dirección:') !!}
                </div>
            </div>

            <div class="row">
                <div class="file-field input-field  col m3 s6">
                    <div class="btn">
                        <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                        {!! Form::file('foto_ced') !!}
                    </div>
                    <div class="file-path-wrapper">
                        {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                    </div>
                </div>
                <div class="file-field input-field  col m3 s6">
                    <div class="btn">
                        <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                        {!! Form::file('foto') !!}
                    </div>
                    <div class="file-path-wrapper">
                        {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto']) !!}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col m6 s12">
                    <div class="form-group">
                        {!! link_to('#','Crear',['class'=>'btn waves-effect waves-light ', 'id'=>'representante_create']) !!}
                        {!! Form::button('Cancelar<i class="fa fa-close"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                    </div>
                </div>
                <div class="pull-right">
                    {!! Form::button('Cerrar',['class'=>'modal-action modal-close waves-effect waves-light btn']) !!}
                </div>
            </div>

            {!! Form::close() !!}

            {{--<div class="input-field col l6 m6 s12">--}}
            {{--{!! Form::select('encuesta_id', $encuestas,null, ['id'=>'encuesta_id', 'placeholder'=>'Seleccione respuesta...']) !!}--}}
            {{--{!! Form::label('encuesta_id','Cómo nos conocio?') !!}--}}
            {{--</div>--}}

        </div>
    </div>
</div><!--/. modal -->





