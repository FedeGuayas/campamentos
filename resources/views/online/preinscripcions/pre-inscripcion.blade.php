@extends('layouts.front.master-plane')


@section('body')

    <div class="navbar-fixed">
        <nav class="nav-extended teal">
            <div class="nav-wrapper">
                <a id="logo-container" href="{{url('/')}}">
                    <img src="{{asset('img/camp/fdg-footer.png')}}" alt="logo" class="responsive-img"
                         style="height: 100%">
                </a>
                <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons">menu</i></a>
                <ul class="right hide-on-med-and-down">
                    <li><a href="{{url('/')}}">Inicio</a></li>
                    <li><a href="#!">Ayuda</a></li>
                </ul>
                <ul class="side-nav" id="mobile-demo">
                    <li><a href="{{url('/')}}">Inicio</a></li>
                    <li><a href="#!">Ayuda</a></li>
                </ul>

            </div>
        </nav>
    </div>

    <div class="no-pad">
        <div class="container">
            <h5 class="header center flow-text teal-text">PREINSCRIPCIONES CAMPAMENTOS DEPORTIVOS</h5>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col s12">

                <div class="card-panel">
                    <div class="card-content">
                        {!! Form::open(['route'=>'pre-inscripcions.store', 'method'=>'POST', 'class'=>'form_noEnter', 'id'=>'form_inscripcion'])  !!}
                        {!! Form::hidden('calendar_id',null,['id'=>'calendar_id']) !!}
                        {!! Form::hidden('program_id',null,['id'=>'program_id']) !!}
                        {!! Form::hidden('descuento_empleado',null,['id'=>'descuento_empleado']) !!} {{--Capturo si es empleado, true or false--}}
                        {!! Form::hidden('descuento_estacion',null,['id'=>'descuento_estacion']) !!}  {{--Capturo la estacion actual VERANO o INVIERNO--}}
                        {{--{!! Form::hidden('user_id',Auth::user()->id) !!}--}}
                        {{--                        {!! Form::hidden('precio',null,['id'=>'precio']) !!}--}}
                        @include('alert.request')
                        @include('alert.success')

                        <br>

                        <div class="row">
                            <div class="input-field col m7 s12">
                                {{--Este campo almacena el id de persona--}}
                                {!! Form::select('representante_id',['placeholder'=>'Seleccione ...'],null,['id'=>'representante_id','required']) !!}
                                {!! Form::label('representante_id', 'Representante:*') !!}
                            </div>
                            <div class="col m2 s6">
                                <a href="#search-repre" type="button"
                                   class="btn-floating red waves-effect waves-light tooltipped"
                                   data-position="top" data-delay="50" data-tooltip="Buscar Representante"><i
                                            class="fa fa-search"></i>
                                </a>
                                <a href="#modal-representante" type="button"
                                   class="btn-floating blue waves-effect waves-light tooltipped modal-representante"
                                   data-position="top" data-delay="50" data-tooltip="Crear Representante"><i
                                            class="fa fa-plus"></i>
                                </a>
                            </div>
                            <div class="col m3 s6 pull-left">
                                <div class="input-field">
                                    {!! Form::checkbox('adulto',null,false,['id'=>'adulto']) !!}
                                    {!! Form::label('adulto','Inscripción para mayores',['class'=>'tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Inscripción para mayores de 18 años']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="alumno">
                                <div class="input-field col m7 s12">
                                    {!! Form::select('alumno_id',['placeholder'=>'Seleccione ...'],null,['id'=>'alumno_id']) !!}
                                    {!! Form::label('alumno_id', 'Alumno:*') !!}
                                </div>
                                <div class="col m3 s6">
                                    <a href="#modal-alumno" type="button"
                                       class="btn-floating blue waves-effect waves-light tooltipped modal-alumno"
                                       data-position="top" data-delay="50" data-tooltip="Crear Alumno">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col l4 right">
                                {!! Form::text('estacion',null,['id'=>'estacion', 'class'=>'hidden']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col m6 s12 input-field">
                                {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione Modulo','id'=>'modulo_id']) !!}
                                {!! Form::label('modulo_id','Modulo:*') !!}
                            </div>
                            <div class="col m6 s12">
                                <div class="input-field">
                                    {{--{!! Form::select('escenario_id', '$escenarios',null, ['id'=>'escenario_id']) !!}--}}
                                    {!! Form::select('escenario_id',['placeholder'=>'Seleccione el escenario deportivo...'],null,['id'=>'escenario_id','required']) !!}
                                    {!! Form::label('escenario_id', 'Escenarios:*') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col m6 s12">
                                <div class="input-field">
                                    {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione la disciplina'],null, ['id'=>'disciplina_id']) !!}
                                    {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
                                </div>
                            </div>
                            <div class="col m6 s12">
                                <div class="input-field">
                                    {!! Form::select('dia_id', ['placeholder'=>'Seleccione los días'],null, ['id'=>'dia_id']) !!}
                                    {!! Form::label('dia_id', 'Dias:*') !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col m3 s12">
                                <div class="input-field">
                                    {!! Form::select('horario_id', ['placeholder'=>'Seleccione los horarios'],null, ['id'=>'horario_id']) !!}
                                    {!! Form::label('horario_id', 'Horario (Edades):*') !!}
                                </div>
                            </div>
                            <div class="col m3 s12">
                                <div class="input-field">
                                    {!! Form::select('nivel',['placeholder' => 'Seleccione...'],null,['class'=>'validate','id'=>'nivel']) !!}
                                    {!! Form::label('nivel','Nivel:') !!}
                                </div>
                            </div>
                            <div class="col m3 s12 input-field">
                                {!! Form::select('fpago_id',$fpagos,null, ['placeholder'=>'Seleccione forma de pago','id'=>'fpago_id']) !!}
                                {!! Form::label('fpago_id', 'Forma de pago:*') !!}
                            </div>
                            <div class="col m3 s12">
                                <div class="input-field disabled pull-right">
                                    <i class="fa fa-usd prefix" aria-hidden="true"></i>
                                    {!! Form::label('valor','Valor:') !!}
                                    {!! Form::number('valor',null,['placeholder'=>'0.00','style'=>'font-size: large','readonly', 'class'=>'valor' ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col m3 s12">
                                <ul class="collapsible" data-collapsible="accordion">
                                    <li>
                                        <div class="collapsible-header"><i class="material-icons">assignment</i>Términos
                                            y Condiciones

                                        </div>
                                        <div class="collapsible-body">
                                            <a href="#terminos-modal" class="waves-effect waves-light tooltipped  btn"
                                               data-position="top" data-delay="50" data-tooltip="Leer Términos"><i class="fa fa-eye right"></i>
                                                Leer
                                            </a>
                                            <a href="{{route('pre-inscripcion.terms-download')}}" onclick="preventDefault();" >
                                                {!! Form::button('<i class="tiny fa fa-download"></i>',['class'=>'btn right indigo waves-effect waves-light tooltipped ', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Descargar']) !!}
                                            </a>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <div class="col m4 s12">
                                <div class="input-field">
                                    {!! Form::checkbox('terms',null,false,['id'=>'terms','class'=>'terms' , 'disabled']) !!}
                                    {!! Form::label('terms','Aceptar Términos y Condiciones',['class'=>'terms']) !!}
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col m5 s12 pull-right">
                                {!! Form::button('<i class="fa fa-close right" aria-hidden="true"></i> Cancelar',['class'=>'btn btn-xs waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'10', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}
                                {{--Pagar--}}
                                {!! Form::button('<i class="fa fa-play right" aria-hidden="true"></i> Guardar',['id'=>'pagar','disabled','class'=>'btn waves-effect waves-light darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Guardar','type'=>'submit']) !!}
                            </div>
                        </div>

                    </div><!--/.card content-->

                    {!! Form::close() !!}
                    {{--@include('campamentos.inscripcions.partials.representante_create')--}}
                    {{--@include('campamentos.inscripcions.partials.alumno_create')--}}
                    {{--Busca el represenatnte --}}


                </div>
            </div>
        </div>
    </div>
    @include('online.preinscripcions.search-representante')
    @include('online.preinscripcions.terminos-modal')
@endsection

@section('scripts')

    <script>

        $(document).ready(function () {

            $("#modulo_id").material_select();
            $("#fpago_id").material_select();

        });

        $(document).ready(function () {
            // para ventana modal de crear alumno
            $('.modal-alumno').modal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '2%' // Ending top style attribute
            });

        });

        $(document).ready(function () {
            // para ventana modal de crear representante
            $('.modal-representante').modal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '2%' // Ending top style attribute
            });

        });

        // para ventana modal de busqueda de representante
        $(document).ready(function () {
            $('.modal').modal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '2%' // Ending top style attribute
            });
        });

        //        $(document).ready(function () {
        //            $('ul.tabs').tabs();
        //        });


        $(function () {
            //prevenir que al dar enter se envie el formulario
            $(".form_noEnter").keypress(function (e) {
                if (e.width === 13) {
                    return false;
                }
            });

            //deshabilitar boton de enviar al dar submit
            $("#form_inscripcion").submit(function () {
                $("#pagar").prop("disabled", true);
            });

            //buscar representante
            $("#Buscar").on('click', function (event) {
                event.preventDefault();
                var datos = $("#search").val();
                var route = "{{route('representatives.beforeSearch')}}";
                var token = $("input[name=_token]").val();
                var loader = $("#loader_page");
                if (datos === "")
                    swal("ERROR", "Debe ingresar datos en el campo de busqueda!", "error");
//                    alert("Error. Debe ingresar datos en el campo de busqueda!");
                else {
                    loader.addClass('active');
                    $.ajax({
                        url: route,
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': token},
                        contentType: 'application/x-www-form-urlencoded',
                        data: {datos: datos},
                        success: function (resp) {
                            $("#search-result").empty().html(resp);
                            loader.removeClass('active');
                            // Comprobar cuando cambia un checkbox
                            $("#table_search input[type=checkbox]").on('change', function () {
                                var representante_id = $("#representante_id");
                                // si se activa
                                if ($(this).is(':checked')) {
//                                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                                    // buscar el td más cercano en el DOM hacia "arriba"
                                    // luego encontrar los td adyacentes a este y obtener el nombre
                                    var name = $(this).closest('td').siblings('td:eq(1)').text();
                                    representante_id.append('<option value="' + $(this).val() + '">' + name + '</option>');
                                    representante_id.addClass("teal-text");
//                                   $("#persona_id").val($(this).val());

                                } else {
                                    loader.removeClass('active');
//                                    console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                                    representante_id.find("option:gt(0)").remove();//elimino las opciones menos la primera
                                    representante_id.removeClass("teal-text");
//                                    $("#persona_id").empty();
                                }
                                representante_id.material_select();
                            });
                        },
                        error: function (resp) {
                            loader.removeClass('active');
//                            console.log(resp);
                            $("#search-result").empty().html("Error en la busqueda");
                        }
                    });
                }
            });

/************************************************************************************************/
            //funcion crear representante
            function crear_representante_ajax() {
                var route = "{{route('admin.representantes.store')}}";
                var token = $("input[name=_token]").val();
//                var representante_id = $("#representante_id");
                var formData = new FormData(document.getElementById("form_representante"));//se envia tod el form al controlador
                //formData.append("dato", "valor"); //agregar otros datos a en viar al controlador
                // formData.append(f.attr("name"), $(this)[0].files[0]);
                $.ajax({
                    url: route,
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': token},
//                    contentType: 'application/x-www-form-urlencoded',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
//                    data:$("#form_representante").serialize(),
                    success: function (resp) {
//                        console.log(resp);
                        var id = resp.persona_id;
                        var name = resp.nombre;
                        var representante_id = $("#representante_id");
                        $("#form_representante").trigger("reset");//limpio el form
                        $("#msj-rep-succes").html(resp.message)
                        $("#mensaje-rep-success").fadeIn();
                        representante_id.append('<option value="' + id + '">' + name + '</option>');
                        representante_id.addClass("teal-text");
                        representante_id.material_select();
                    },
                    error: function (resp) {
                        //console.log(resp.responseJSON)
                        var errors = '';
                        $.each(resp.responseJSON, function (ind, elem) {
                            errors += elem + '<br>';
                        });
                        $('#msj-rep-error').show().html(errors);
                        $("#mensaje-rep-error").fadeIn();
                        representante_id.removeClass("teal-text");
                        representante_id.find("option:gt(0)").remove();
                    }

                });
            }

            //llamar a funcion crear representante
            $("#representante_create").on("click", function (event) {
                event.preventDefault();
                crear_representante_ajax();
            });

            //funcion crear alumno
            function crear_alumno_ajax() {
                var route = "{{route('admin.alumnos.store')}}";
                var alumno_id = $("#alumno_id");
                var token = $("input[name=_token]").val();
                var formData = new FormData(document.getElementById("form_alumno"));
                formData.append("persona_id", $("#representante_id").val());
                $.ajax({
                    url: route,
                    type: "POST",
                    headers: {'X-CSRF-TOKEN': token},
//                    contentType: 'application/x-www-form-urlencoded',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
//                    data:$("#form_representante").serialize(),
                    success: function (resp) {
                        console.log(resp);
                        var id = resp.alumno_id;
                        var name = resp.nombre;
                        $("#form_alumno").trigger("reset");//limpio el form
                        $("#msj-succes").html(resp.message)
                        $("#mensaje-success").fadeIn();
                        alumno_id.append('<option value="' + id + '">' + name + '</option>');
                        alumno_id.addClass("teal-text");
                        alumno_id.material_select();
                    },
                    error: function (resp) {
                        console.log(resp.responseJSON)
                        var errors = '';
                        $.each(resp.responseJSON, function (ind, elem) {
                            errors += elem + '<br>';
                        });
                        $('#msj-error').show().html(errors);
                        $("#mensaje-error").fadeIn();
                        alumno_id.removeClass("teal-text");
                        alumno_id.find("option:gt(0)").remove();
                        $("#alumno_id").empty();
                    }
                });
            }

            $(document).ready(function () {
                //llamar a funcion crear alumno
                $("#alumno_create").on("click", function (event) {
                    event.preventDefault();
                    crear_alumno_ajax();
                });
            });


            $(document).ready(function () {
                // Adulto que se kiere inscribir
                $("#adulto").on('change', function () {
                    if ($(this).is(':checked')) {
                        $("div").remove(".alumno");
                    } else {
                    }
//               representante_id.material_select();
                });
            });


        });

        $(document).ready(function () {
            //solo si se selecciona forma de pago habilitar los term
            $("#fpago_id").on('change', function () {
                if ($(this).val() == 0) {
                    $("#terms").attr("disabled", true).prop('checked', false);
                    $("#pagar").prop('disabled', true);
                } else {
                    $("#terms").removeAttr("disabled");
                }
            });
            // Aceptar los terminos
            $("#terms").on('change', function () {
                if ($(this).is(':checked')) {
                    $("#pagar").prop('disabled', false);
                } else {
                    $("#pagar").prop('disabled', true);
                }
            });

        });


    </script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/pre-inscripcion.js") }}" type="text/javascript"></script>

@endsection