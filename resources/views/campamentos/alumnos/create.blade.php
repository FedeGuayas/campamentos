@extends('layouts.admin.index')

@section('title', 'Crear Alumno')

@section('content')

    <div class="row">
        <div class="col l8 m12 s12">
            <div class="card-panel">
                <h5 class="header teal-text text-darken-2">Crear Alumno</h5>
                <div class="card-content ">
                    @include('alert.request')
                    {!! Form::open(['route'=>'admin.alumnos.store', 'method'=>'POST','files'=>'true'])  !!}
                    <div class="col s12">

                        <div class="input-field col l8 m8 s10">
                            {!! Form::text('representate',null,['class'=>'validate','required','placeholder'=>'Representante', 'id'=>'representante','disabled']) !!}
                            {!! Form::hidden('persona_id',null,['id'=>'persona_id','required']) !!}
                        </div>
                        <div class="input-field col l2 m2 s1 offset-l1 ">
                            {!! Form::button('<i class="fa fa-search" aria-hidden="true"></i>',['class'=>'btn waves-effect waves-light darken-1 modal-search' ,'data-target'=>'modal-search' ]) !!}
                        </div>


                        <div class="input-field col l6 m6 s12 ">
                            <i class="fa fa-user prefix"></i>
                            {!! Form::label('nombres','Nombres:*') !!}
                            {!! Form::text('nombres',null,['class'=>'validate','required']) !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('apellidos','Apellidos:*') !!}
                            {!! Form::text('apellidos',null,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('tipo_doc', ['Cedula' => 'Cedula', 'Pasaporte' => 'Pasaporte', 'NoDoc' => 'NoDoc'],null, ['id'=>'tipo_doc']) !!}
                            {!! Form::label('tipo_doc', 'Tipo doc:') !!}
                        </div>
                        <div class="input-field col l6 m6 s12">
                            {!! Form::label('num_doc','Número del documento:*') !!}
                            {!! Form::text('num_doc',null,['class'=>'validate','required']) !!}
                        </div>

                        <div class="input-field col l6 m6 s12">
                            {!! Form::select('genero', ['Masculino' => 'Masculino', 'Femenino' => 'Femenino'],null, ['id'=>'genero']) !!}
                            {!! Form::label('genero','Género:') !!}
                        </div>
                        <div class="form-group col l6 m6 s12">
                            {!! Form::label('fecha','Fecha de Nacimiento:',['class'=>'label-control']) !!}
                            {{  Form::date('fecha_nac',null,[ 'class'=>'validate','required']) }}
                        </div>

                        <div class="input-field col l2 m6 s12 offset-l6">
                            {!! Form::checkbox('discapacitado',null,false,['id'=>'discapacitado']) !!}
                            {!! Form::label('discapacitado','Discapacitado') !!}
                        </div>

                        <div class="input-field  col l12 m6 s12">
                            <i class="fa fa-pencil prefix"></i>
                            {!! Form::textarea('direccion',null,['class'=>'materialize-textarea validate','id'=>'direccion','length'=>'150']) !!}
                            {!! Form::label('direccion','Dirección:') !!}
                        </div>


                        {{--<div class="input-field col l6 m6 s12">--}}
                        {{--{!! Form::select('discapacitado', ['NO' => 'No','SI' => 'Si' ],null, ['id'=>'discapacitado','placeholder'=>'Seleccione ...']) !!}--}}
                        {{--{!! Form::label('discapacitado','Discapacitado?:') !!}--}}
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
                {!! Form::button('Crear<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                {!! Form::button('Cancelar<i class="fa fa-close right"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                <a href="{{ route('admin.alumnos.index') }}" class="tooltipped" data-position="top" data-delay="50"
                   data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
                {!! Form::close() !!}
                @include('campamentos.alumnos.search')

                <div id="representantes_id"></div>

            </div><!--/.card content-->
        </div><!--/.card panel-->
    </div><!--/.col s12-->
    </div><!--/.row-->

@endsection

@section('scripts')
    <script>

        $(document).ready(function () {
            // para ventana modal de busqueda
            $('.modal-search').leanModal({
                        dismissible: false, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        in_duration: 300, // Transition in duration
                        out_duration: 200, // Transition out duration
                        starting_top: '4%', // Starting top style attribute
                        ending_top: '10%', // Ending top style attribute
            });
        });



        $(function(){

            $(".form_noEnter").keypress(function(e){
                if(e.width == 13){
                    return false;
                }
            });


            $("#Buscar").on('click', function (event) {
                event.preventDefault();
                var datos = $("#search").val();
                var route = "{{route('admin.representantes.beforeSearch')}}";
                var token = $("input[name=_token]").val();
                if (datos == "")
                    alert("Error. Debe ingresar datos en el campo de busqueda!");
                else {
                    $.ajax({
                        url: route,
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': token},
                        contentType: 'application/x-www-form-urlencoded',
                        data: {datos},
                        success: function (resp) {
                            $("#search-result").empty().html(resp);

                            // Comprobar cuando cambia un checkbox
                            $("#table_search input[type=checkbox]").on('change', function() {

                                // si se activa
                                if ($(this).is(':checked') ) {
                                    console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Seleccionado");
                                    // buscar el td más cercano en el DOM hacia "arriba"
                                    // luego encontrar los td adyacentes a este y obtener el nombre
                                    var name=$(this).closest('td').siblings('td:eq(1)').text();
                                    // poner el texto en el input
                                    $("#representante").val(name);
                                    // guardo el id para enviarlo al controlador
                                    $("#persona_id").val($(this).val());
                                    $("#representante").addClass("teal-text");
                                } else {
                                    console.log("Checkbox " + $(this).prop("id") +  " (" + $(this).val() + ") => Deseleccionado");
                                    $("#representante").removeClass("teal-text");
                                    $("#persona_id").val("");
                                    $("#representante").val("");
                                }
                            });
                        },
                        error: function (resp) {
                            console.log(resp);
                            $("#search-result").empty().html("Error en la busqueda");
                        }
                    });
                }
            });

            $("#ADD_REP").on('click',function () {
//            $("#table_search input[type=checkbox]").each(function(index){
                $("#modal-search").closeModal();

            });

        });

    </script>

@endsection

