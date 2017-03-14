<div id="modal-create-alumno-{{$rep->id}}" class="modal hoverable">

    <div class="modal-body">
        {{--Crear Alumno--}}
        {!! Form::open(['route'=>['user.alumno.store',$rep->id], 'method'=>'POST','files'=>'true'])  !!}
        <div class="row">
            <h5 class="header teal-text text-darken-2">Crear Alumno</h5>
            <div class="input-field col s6">
                {!! Form::label('representante','Representante:*') !!}
                {!! Form::text('representate',$rep->persona->getNombreAttribute(),['class'=>'validate teal-text','required','placeholder'=>'Representante', 'id'=>'representante','disabled']) !!}
            </div>
        </div>

        <div class="row">
            <div class="input-field col l4 m6 s12 ">
                <i class="fa fa-user prefix"></i>
                {!! Form::label('nombres','Nombres:*') !!}
                {!! Form::text('nombres',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
            </div>
            <div class="input-field col l4 m6 s12">
                {!! Form::label('apellidos','Apellidos:*') !!}
                {!! Form::text('apellidos',null,['class'=>'validate','required','style'=>'text-transform:uppercase']) !!}
            </div>
        </div>

        <div class="row">
            <div class="form-group col l3 m4 s12">
                {!! Form::label('tipo_doc', 'Tipo doc:*') !!}
                {!! Form::select('tipo_doc', ['CEDULA' => 'CEDULA', 'PASAPORTE' => 'PASAPORTE'],null, ['id'=>'tipo_doc','required','class'=>'browser-default','placeholder' => 'Seleccione...']) !!}
            </div>
            <div class="input-field col l3 m4 s12">
                {!! Form::label('num_doc','Número del documento:*') !!}
                {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
            </div>
            <div class="form-group col l3 m4 s12">
                {!! Form::label('genero','Género:*') !!}
                {!! Form::select('genero', ['MASCULINO' => 'MASCULINO', 'FEMENINO' => 'FEMENINO'],null, ['id'=>'genero','required','class'=>'browser-default','placeholder' => 'Seleccione...']) !!}
            </div>
            <div class="form-group col l3 m4 s12">
                {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
            </div>
        </div>

        <div class="row">
            <div class="file-field input-field  col l3 m6 s6">
                <i class="fa  fa-2x fa-image prefix" aria-hidden="true"></i>
                {!! Form::text('foto_ced','Fotocopia Cedula*',['class'=>'file-path validate']) !!}
                {!! Form::file('foto_ced',['required']) !!}
            </div>
            <div class="file-field input-field  col l3 m6 s6">
                <i class="fa fa-2x fa-image prefix" aria-hidden="true"></i>
                {!! Form::text('foto','Foto Carnet*',['class'=>'file-path validate']) !!}
                {!! Form::file('foto',['required']) !!}
            </div>
            <div class="col s6">
                <div class="clearfix">
                    <div class="center-align">
                        {!! Form::button('<i class="fa fa-save"></i>', ['class'=>'btn waves-effect waves-light tooltipped blue darken-1', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Guardar','type' => 'submit']) !!}
                        {!! Form::button('<i class="fa fa-eraser"></i>',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}
                        {!! Form::button('<i class="fa fa fa-close"></i>', ['class'=>'btn modal-close waves-effect waves-light tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Cerrar']) !!}
                    </div>
                </div>
            </div>
        </div>

        {!! Form::close() !!}

    </div>{{--/modal-body--}}
</div>{{--/modal--}}

