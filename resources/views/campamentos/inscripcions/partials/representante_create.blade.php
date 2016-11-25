<div id="modal-representante" class="modal">
    <div class="modal-content">
        <div class="card-panel">
                    <h5 class="header teal-text text-darken-2">Crear Representante</h5>
                    <div class="card-content ">
                        {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_representante']) !!}
{{--                        {!! Form::open(['route'=>'admin.representantes.store', 'method'=>'POST','files'=>'true'])  !!}--}}

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
                                {!! Form::text('nombres',null,['class'=>'validate','required']) !!}
                            </div>
                            <div class="input-field col l6 m6 s12">
                                {!! Form::label('apellidos','Apellidos:*') !!}
                                {!! Form::text('apellidos',null,['class'=>'validate','required']) !!}
                            </div>

                            <div class="input-field col l4 m6 s12">
                                {!! Form::select('tipo_doc', ['Cedula' => 'Cedula', 'Pasaporte' => 'Pasaporte'],null,['id'=>'tipo_doc']) !!}
                                {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                            </div>
                            <div class="input-field col l4 m6 s12">
                                {!! Form::label('num_doc','Número del documento:*') !!}
                                {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
                            </div>

                            <div class="input-field col l4 m6 s12">
                                {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'],null,['id'=>'genero']) !!}
                                {!! Form::label('genero','Género:') !!}
                            </div>
                            {{--<div class="form-group col l6 m6 s12">--}}
                                {{--{!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}--}}
                                {{--{{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}--}}
                            {{--</div>--}}

                            <div class="input-field col l6 m6 s12">
                                <i class="fa fa-envelope prefix"></i>
                                {!! Form::label('email','Correo:*') !!}
                                {!! Form::email('email',null,['class'=>'validate']) !!}

                            </div>

                            <div class="input-field  col l6 m6 s12">
                                <i class="fa fa-pencil prefix"></i>
                                {!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255']) !!}
                                {!! Form::label('direccion','Dirección:') !!}
                            </div>

                            <div class="input-field  col l6 m6 s12">
                                <i class="fa fa-phone prefix"></i>
                                {!! Form::text('phone',null,['class'=>'validate','id'=>'phone']) !!}
                                {!! Form::label('phone','Teléfono1:*') !!}
                            </div>
                            <div class="input-field  col l6 m6 s12">
                                <i class="fa fa-phone prefix"></i>
                                {!! Form::text('telefono',null,['class'=>'validate','id'=>'telefono']) !!}
                                {!! Form::label('telefono','Teléfono2:') !!}
                            </div>

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

                            {{--<div class="input-field col l6 m6 s12">--}}
                            {{--{!! Form::select('encuesta_id', $encuestas,null, ['id'=>'encuesta_id', 'placeholder'=>'Seleccione respuesta...']) !!}--}}
                            {{--{!! Form::label('encuesta_id','Cómo nos conocio?') !!}--}}
                            {{--</div>--}}

                        </div>

                    </div>

            <div class="">
                {!! link_to('#','Crear',['class'=>'btn waves-effect waves-light', 'id'=>'representante_create']) !!}
{{--                {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}--}}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                {!! Form::close() !!}
                {!! Form::button('Cerrar',['class'=>'modal-action modal-close waves-effect waves-ligh btn right']) !!}
            </div>


                </div><!--/.card content-->

            </div><!--/.card panel-->




</div>





