<div id="modal-alumno" class="modal">
    <div class="modal-content">
        <div class="card-panel">
            <h5 class="header teal-text text-darken-2">Crear Alumno</h5>
            <div class="card-content ">
                @include('alert.request')
                {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_alumno']) !!}
                {{--seleccionada en representente, es id_persona--}}
                <div id="mensaje-success" class="alert alert-success alert-dismissible" role="alert" style="display: none">
                    <button type="button" class="close" data-dismiss="alert" aria-labelledby="Close"><span aria-hidden="true">&times;</span></button>
                    <li><strong id="msj-succes"></strong></li>
                </div>
                <div id="mensaje-error" class="alert alert-danger alert-dismissible" role="alert" style="display: none">
                    <button type="button" class="close" data-dismiss="alert" aria-labelledby="Close"><span aria-hidden="true">&times;</span></button>
                    <ul>
                        <li><strong id="msj-error"></strong></li>
                    </ul>
                </div>

                <div class="col s12">


                    <div class="input-field col l6 m6 s12 ">
                        <i class="fa fa-user prefix"></i>
                        {!! Form::label('nombres','Nombres:*') !!}
                        {!! Form::text('nombres',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                    </div>
                    <div class="input-field col l6 m6 s12">
                        {!! Form::label('apellidos','Apellidos:*') !!}
                        {!! Form::text('apellidos',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                    </div>

                    <div class="input-field col l4 m4 s12">
                        {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null, ['id'=>'tipo_doc']) !!}
                        {!! Form::label('tipo_doc', 'Tipo doc:') !!}
                    </div>
                    <div class="input-field col l4 m4 s12">
                        {!! Form::label('num_doc','Número del documento:*') !!}
                        {!! Form::text('num_doc',null,['class'=>'validate','required','onkeypress'=>"if (this.value.length > 9) {return false}"]) !!}
                    </div>

                    <div class="input-field col l4 m4 s12">
                        {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null, ['id'=>'genero']) !!}
                        {!! Form::label('genero','Género:') !!}
                    </div>


                    {{--<div class="input-field  col l8 m6 s12">--}}
                        {{--<i class="fa fa-pencil prefix"></i>--}}
                        {{--{!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'150','style'=>'text-transform:uppercase']) !!}--}}
                        {{--{!! Form::label('direccion','Dirección:') !!}--}}
                    {{--</div>--}}
                    <div class="form-group col l4 m4 s12 offset-l4">
                        {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                        {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
                    </div>

                    {{--<div class="input-field col l2 m6 s12 offset-l6">--}}
                    {{--{!! Form::checkbox('discapacitado',null,false,['id'=>'discapacitado']) !!}--}}
                    {{--{!! Form::label('discapacitado','Discapacitado') !!}--}}
                    {{--</div>--}}

                    <div class="file-field input-field  col l6 m6 s12">
                        <div class="btn">
                            <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                            {!! Form::file('foto_ced') !!}
                        </div>
                        <div class="file-path-wrapper">
                            {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Foto-Cedula']) !!}
                        </div>
                    </div>
                    <div class="file-field input-field  col l6 m6 s12">
                        <div class="btn">
                            <span><i class="fa fa fa-file-image-o prefix" aria-hidden="true"></i></span>
                            {!! Form::file('foto') !!}
                        </div>
                        <div class="file-path-wrapper">
                            {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto']) !!}
                        </div>
                    </div>

                </div>
            </div>
            <div >
                {!! link_to('#','Crear',['class'=>'btn waves-effect waves-light', 'id'=>'alumno_create']) !!}
                {{--            {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}--}}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                {!! Form::close() !!}
                {!! Form::button('Cerrar',['class'=>'modal-action modal-close waves-effect waves-ligh btn right']) !!}
            </div>

        </div><!--/.card content-->
    </div>
</div>