<div id="modal-edit-representante-{{$rep->id}}" class="modal hoverable">

    <h6 class="header teal-text text-darken-2">Editar representante</h6>

    <div class="modal-body">

        {!! Form::model($representante,['route'=>['user.representante.update',$rep->id], 'method'=>'PUT', 'files'=>'true']) !!}

            <div class="row">
                <div class="input-field col l4 m6 s12 ">
                    <i class="fa fa-user prefix"></i>
                    {!! Form::label('nombres','Nombres:*') !!}
                    {!! Form::text('nombres',$representante[0]->persona->nombres,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>
                <div class="input-field col l4  m6 s12">
                    {!! Form::label('apellidos','Apellidos:*') !!}
                    {!! Form::text('apellidos',$representante[0]->persona->apellidos,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
                </div>
                <div class="form-group col l2 m4 s12">
                    {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                    {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],$representante[0]->persona->tipo_doc, ['id'=>'tipo_doc','class'=>'browser-default','required','placeholder' => 'Seleccione...']) !!}
                </div>
                <div class="input-field col l2 m4 s12">
                    {!! Form::label('num_doc','Número:*') !!}
                    {!! Form::text('num_doc',$representante[0]->persona->num_doc,['class'=>'validate','required']) !!}
                </div>
            </div>

            <div class="row">
                <div class="form-group col l2 m4 s12">
                    {!! Form::label('genero','Género:*') !!}
                    {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],$representante[0]->persona->genero, ['id'=>'genero','required','class'=>'browser-default','required','placeholder' => 'Seleccione...']) !!}
                </div>
                <div class="input-field col l4 m4 s12">
                    <i class="fa fa-envelope prefix"></i>
                    {!! Form::label('email','Correo:*') !!}
                    {!! Form::email('email',$representante[0]->persona->email,['class'=>'validate','required']) !!}
                </div>
                <div class="input-field  col l3 m4 s6">
                    <i class="fa fa-phone prefix"></i>
                    {!! Form::text('telefono',$representante[0]->persona->telefono,['class'=>'validate','id'=>'telefono', 'required']) !!}
                    {!! Form::label('telefono','Teléfono1*:') !!}
                </div>
                <div class="input-field  col l3 m4 s6">
                    <i class="fa fa-phone prefix"></i>
                    {!! Form::text('phone',$representante[0]->persona->phone,['class'=>'validate','id'=>'phone']) !!}
                    {!! Form::label('phone','Teléfono2:') !!}
                </div>
            </div>

            <div class="row">
                <div class="input-field  col l6 m7 s12">
                    <i class="fa fa-pencil prefix"></i>
                    {!! Form::textarea('direccion',$representante[0]->persona->direccion,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'255','required','style'=>'text-transform:uppercase']) !!}
                    {!! Form::label('direccion','Dirección:*') !!}
                </div>
                <div class="form-group col l4 m4 s12">
                    {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                    {{  Form::date('fecha_nac',$representante[0]->persona->fecha_nac,[ 'class'=>'validate','required']) }}
                </div>
            </div>

            <div class="row">

                <div class="file-field input-field col l3 m3 s12">
                    <i class="fa  fa-2x fa-image prefix" aria-hidden="true"></i>
                    {!! Form::text('foto_ced',null,['class'=>'file-path validate','placeholder'=>'Fotocopia Cedula*']) !!}
                    {!! Form::file('foto_ced') !!}
                    @if (($representante[0]->foto_ced)!="")
                        <img src="{{ asset('dist/img/representantes/cedula/'.$representante[0]->foto_ced)}}" style='max-width: 100px' class="img-thumbnail">
                    @endif
                </div>

                <div class="file-field input-field col l3 m3 s12">
                    <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                    {!! Form::text('foto',null,['class'=>'file-path validate','placeholder'=>'Foto Carnet*']) !!}
                    {!! Form::file('foto') !!}
                    @if (($representante[0]->foto)!="")
                        <img src="{{ asset('dist/img/representantes/perfil/'.$representante[0]->foto)}}" style='max-width: 100px' class="img-thumbnail">
                    @endif
                </div>

                <div class="col l6 m6 s12 center-align">
                    {!! Form::button('<i class="fa fa-pencil-square-o "></i>', ['class'=>'btn waves-effect waves-light tooltipped blue darken-1', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Actualizar','type' => 'submit']) !!}
                    {!! Form::button('<i class="fa fa-eraser"></i>',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}
                    {!! Form::button('<i class="fa fa fa-close"></i>', ['class'=>'btn modal-close waves-effect waves-light tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cerrar']) !!}
                </div>
            </div>

            {!! Form::close() !!}


        </div><!--/.modal-body-->
    </div><!--/.modal-->








