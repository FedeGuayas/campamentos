@extends('layouts.admin.index')

@section('title', 'Inscripción')

@section('content')


    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                <ul class="tabs">
                    <li class="tab col s4">
                        <a class="active" href="#inscripcion">
                            <h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                <span class="hide-on-med-and-down">Inscripción</span>
                            </h5>
                        </a>
                    </li>
                    <li class="tab col s4">
                        <a href="#detalle" id="getCurso">
                            <h5><i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                <span class="hide-on-med-and-down">Detalle</span>
                                <span class="label label-danger">{{Session::has('curso') ? Session::get('curso')->totalCursos : ''}}</span>
                            </h5>
                        </a>
                    </li>
                    <li class="tab col s4 ">
                        <a href="#facturacion">
                            <h5><i class="fa fa-money" aria-hidden="true"></i>
                                <span class="hide-on-med-and-down">Facturación</span>
                            </h5>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="card-panel">
                {{--<h5 class="header teal-text text-darken-2">Inscripción</h5>--}}
                {!! Form::open(['route'=>'admin.inscripcions.store', 'method'=>'POST', 'class'=>'form_noEnter', 'id'=>'form_inscripcion'])  !!}
                <div id="inscripcion">
                    @include('campamentos.inscripcions.partials.inscripcion')
                </div>
                <div id="facturacion">
                    @include('campamentos.inscripcions.partials.facturacion')
                </div>

                <div id="detalle"></div>
                <input type="text" id="cursos_session" hidden
                       value="{{Session::has('curso') ? Session::get('curso')->totalCursos : 0}}">
                <input type="text" id="cursos_precio_session" hidden
                       value="{{Session::has('curso') ? Session::get('curso')->totalPrecio : 0}}">
            </div><!--/.card panel-->
        </div><!--/.card col-->
    </div><!--/.row-->

@endsection

@section('scripts')
    <script src="{{ asset("js/dropdown-province.js") }}" type="text/javascript"></script>
    <script>

        var url_getCanton = "{{route('getCanton',':ID_Provincia')}}";
        var url_getParroquia = "{{route('getParroquia',':ID_Canton')}}";

        $(document).ready(function () {
            var cursos_session=parseInt($("#cursos_session").val());

            if (cursos_session > 1 ) {
                $("#pagar").prop("disabled", false);
            }else{
                $("#pagar").prop("disabled", true);
            }

        });

        $(document).ready(function () {
            // para ventana modal de crear alumno
            $('.modal-alumno').leanModal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '2%', // Ending top style attribute
                complete: function() { $('.fixed-action-btn').closeFAB(); }
            });

        });

        $(document).ready(function () {
            // para ventana modal de crear representante
            $('.modal-representante').leanModal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
//                starting_top: '4%', // Starting top style attribute
//                ending_top: '2%', // Ending top style attribute
                complete: function() { $('.fixed-action-btn').closeFAB(); }
            });

        });

        $(document).ready(function () {
            // para ventana modal de busqueda de representante
            $('.modal-search').leanModal({
                dismissible: false, // Modal can be dismissed by clicking outside of the modal
                opacity: .5, // Opacity of modal background
                in_duration: 300, // Transition in duration
                out_duration: 200, // Transition out duration
                starting_top: '4%', // Starting top style attribute
                ending_top: '2%', // Ending top style attribute
                complete: function() { $('.fixed-action-btn').closeFAB(); }
            });
        });

        $(document).ready(function () {
            $('ul.tabs').tabs();
        });


        $(function () {
            //prevenir que al dar enter se envie el formulario
            $(".form_noEnter").keypress(function (e) {
                if (e.which === 13) {
                    return false;
                }
            });

            //deshabilitar boton de enviar al dar submit
            $("#form_inscripcion").submit(function() {

                var fpago_id = $("#fpago_id").val();
                var boton_pagar = $("#pagar");
                var otro_factura = $("#otro_factura");

                if ( fpago_id === '' ) {
                    swal(" :(", 'Debe seleccionar la forma de pago', "warning");
                    return false;
                }
                if ( otro_factura.prop("checked")) {
                //agrego este otro formulario
                $("#form_otra_facturacion").find(":input").appendTo("#form_inscripcion");

                }



                boton_pagar.prop("disabled",true);

            });


            //buscar representante
            $("#Buscar").on('click', function (event) {
                event.preventDefault();
                var datos = $("#search").val();
                var route = "{{route('admin.representantes.beforeSearch')}}";
                var token = $("input[name=_token]").val();
                var loader=$("#loader_page");
                if (datos === "")
                    swal("!!!", 'Debe ingresar datos en el campo de busqueda', "warning");
//                    alert("Error. Debe ingresar datos en el campo de busqueda!");
                else {
                    loader.addClass('active');
                    $.ajax({
                        url: route,
                        type: "POST",
                        headers: {'X-CSRF-TOKEN': token},
                        contentType: 'application/x-www-form-urlencoded',
                        data: {datos:datos},
                        success: function (resp) {
                            $("#search-result").empty().html(resp);
                            loader.removeClass('active');
                            // Comprobar cuando cambia un checkbox
                            $("#table_search input[type=checkbox]").on('change', function () {
                                var representante_id = $("#representante_id");
                                // si se activa
                                if ($(this).is(':checked')) {
                                    //console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Seleccionado");
                                    // buscar el td más cercano en el DOM hacia "arriba"
                                    // luego encontrar los td adyacentes a este y obtener el nombre
                                    var name = $(this).closest('td').siblings('td:eq(1)').text();
                                    representante_id.append('<option value="' + $(this).val() + '">' + name + '</option>');
                                    representante_id.addClass("teal-text");
//                                   $("#persona_id").val($(this).val());

                                } else {
                                    loader.removeClass('active');
                                    //console.log("Checkbox " + $(this).prop("id") + " (" + $(this).val() + ") => Deseleccionado");
                                    representante_id.find("option:gt(0)").remove();//elimino las opciones menos la primera
                                    representante_id.removeClass("teal-text");
//                                    $("#persona_id").empty();
                                }
                                representante_id.material_select();
                            });
                        },
                        error: function (resp) {
                            loader.removeClass('active');
                            //console.log(resp);
                            $("#search-result").empty().html("Error en la busqueda");
                        }
                    });
                }
            });


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
                        //console.log(resp);
                        var id = resp.alumno_id;
                        var name = resp.nombre;
                        $("#form_alumno").trigger("reset");//limpio el form
                        $("#msj-succes").html(resp.message);
                        $("#mensaje-success").fadeIn();
                        alumno_id.append('<option value="' + id + '">' + name + '</option>');
                        alumno_id.addClass("teal-text");
                        alumno_id.material_select();
                    },
                    error: function (resp) {
                        //console.log(resp.responseJSON)
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


            //agregar cursos al carrito al dar click en +
            function add_cursos_ajax() {
//             alert($("#add-curso").attr("value"));
                var id = $("#calendar_id").val();
                var form = $("#form_inscripcion");
                var data = form.serialize();
                //agregar id a la ruta dinamicamente
                var route = $("#add-cursos").attr('href').replace(':CALENDAR', id);
                var token = $("input[name=_token]").val();

//               var formData = new FormData(document.getElementById("form_representante"));//se envia tod el form al controlador
                //formData.append("dato", "valor"); //agregar otros datos a en viar al controlador
                // formData.append(f.attr("name"), $(this)[0].files[0]);
                $.ajax({
                    url: route,
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': token},
//                    contentType: 'application/x-www-form-urlencoded',
                    data: data,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (resp) {
                        //console.log(resp);
//                        alert(resp.message);
                        swal("", resp.message, "success");
                        var total_cursos = resp.totalCursos;
                        $("#getCurso>h5>span").html(total_cursos);

                    },
                    error: function (resp) {
                       // console.log(resp);
                        swal("", "No se pudo realizar la acción", "error");
                    }
                });
            }

            //llamar a funcion de adicionar cursos
            $("#add-cursos").on("click", function (event) {
                event.preventDefault();
                add_cursos_ajax();
            });


            //obtener coleccion de cursos
            $("#getCurso").on('click', function (event) {
                event.preventDefault();
                var route = "{{route('inscripciones.multipleCursos')}}";
                var token = $("input[name=_token]").val();

                $.ajax({
                    url: route,
                    type: "GET",
                    headers: {'X-CSRF-TOKEN': token},
                    contentType: 'application/x-www-form-urlencoded',
//                       data: {datos},
                    success: function (resp) {
                       // console.log(resp);
                        $("#detalle").empty().html(resp);
                    },
                    error: function (resp) {
                        //console.log(resp);
                        $("#detalle").empty().html("!!! No Hay Productos en el Carrito ");
                    }
                });
            });

            // Inscripcion de adulto
            $(document).ready(function () {

                $("#adulto").on('change', function () {
                    var alumno_id = $("#alumno_id");
                    var modulo_id = $("#modulo_id");
                    if ($(this).is(':checked')) {
                        alumno_id.val("option:eq(0)").prop('selected', true);
                        modulo_id.val("option:eq(0)").prop('selected', true);
                        alumno_id.prop('disabled',true);
                        $(".alumno a:first").addClass('disabled');
                    } else {
                       alumno_id.prop('disabled',false);
                       $(".alumno a:first").removeClass('disabled');
                    }
                    alumno_id.material_select();
                    modulo_id.material_select();
                });

                $("#otro_factura").on('change', function () {
                    var fact_nombres = $(".fact_nombres");
                    var fact_ci = $(".fact_ci");
                    var fact_email = $(".fact_email");
                    var fact_phone = $(".fact_phone");
                    var fact_direccion = $(".fact_direccion");

                    if ($(this).is(':checked')) {
                        fact_nombres.prop('readonly',false);
                        fact_ci.prop('readonly',false);
                        fact_email.prop('readonly',false);
                        fact_phone.prop('readonly',false);
                        fact_direccion.prop('readonly',false);
                    } else {
                        fact_nombres.prop('readonly',true).val('');
                        fact_ci.prop('readonly',true).val('');
                        fact_email.prop('readonly',true).val('');
                        fact_phone.prop('readonly',true).val('');
                        fact_direccion.prop('readonly',true).val('');
                    }

                });



            });
















//****************CARRITO****************************************//

            //agregar cursos al carrito
//            function add_cart_ajax() {
////             alert($("#add-to-cart").attr("value"));
//                var id = $("#calendar_id").val();
//                var form = $("#form_inscripcion");
//                var data = form.serialize();
//                //agregar id a la ruta dinamicamente
//                var route = $("#add-to-cart").attr('href').replace(':CALENDAR', id);
//                var token = $("input[name=_token]").val();
//
////               var formData = new FormData(document.getElementById("form_representante"));//se envia tod el form al controlador
//                //formData.append("dato", "valor"); //agregar otros datos a en viar al controlador
//                // formData.append(f.attr("name"), $(this)[0].files[0]);
//                $.ajax({
//                    url: route,
//                    type: "GET",
//                    headers: {'X-CSRF-TOKEN': token},
////                    contentType: 'application/x-www-form-urlencoded',
//                    data: data,
//                    cache: false,
//                    contentType: false,
//                    processData: false,
//                    success: function (resp) {
//                        alert(resp.message);
//
//                    },
//                    error: function (resp) {
//                        alert("No se pudo realizar la acción");
//                    }
//                });
//            }

            //llamar a funcion add-to-cart
//            $("#add-to-cart").on("click", function (event) {
//                event.preventDefault();
//                add_cart_ajax();
//            });


            //obtener el carrito
            {{--$("#getCart").on('click', function (event) {--}}
                {{--event.preventDefault();--}}
                {{--var route = "{{route('product.shoppingCart')}}";--}}
                {{--var token = $("input[name=_token]").val();--}}

                {{--$.ajax({--}}
                    {{--url: route,--}}
                    {{--type: "GET",--}}
                    {{--headers: {'X-CSRF-TOKEN': token},--}}
                    {{--contentType: 'application/x-www-form-urlencoded',--}}
{{--//                       data: {datos},--}}
                    {{--success: function (resp) {--}}
                        {{--console.log(resp);--}}
                        {{--$("#detalle").empty().html(resp);--}}
                    {{--},--}}
                    {{--error: function (resp) {--}}
                        {{--console.log(resp);--}}
                        {{--$("#detalle").empty().html("!!! No Hay Productos en el Carrito ");--}}
                    {{--}--}}
                {{--});--}}
            {{--});--}}

        });


    </script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/updateCosto.js?ver=2.2") }}" type="text/javascript"></script>
    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdown.js?ver=2.2") }}" type="text/javascript"></script>

@endsection