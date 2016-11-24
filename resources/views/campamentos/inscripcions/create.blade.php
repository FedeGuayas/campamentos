@extends('layouts.admin.index')

@section('title', 'Indcripción')

@section('content')


    <div class="row">
        <div class="col l12">
            <div class="card-panel">
                <ul class="tabs">
                    <li class="tab col s4"><a class="active" href="#inscripcion"><h5><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Inscripción</h5></a></li>
                    <li class="tab col s4"><a href="#test2"><h5><i class="fa fa-shopping-cart" aria-hidden="true"></i> Detalle</h5></a></li>
                    <li class="tab col s4 "><a href="#test3"><h5><i class="fa fa-money" aria-hidden="true"></i> Facturación</h5></a></li>
                </ul>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col  s12">
            <div class="card-panel">
                {{--<h5 class="header teal-text text-darken-2">Inscripción</h5>--}}
                <div id="inscripcion">
                    <br>
                    @include('campamentos.inscripcions.partials.inscripcion')
                </div>


            </div><!--/.card panel-->
        </div><!--/.card col-->
    </div><!--/.row-->

@endsection

@section('scripts')

    <script>

       $("#modulo_id").material_select();

       $(document).ready(function () {
           // para ventana modal de busqueda
           $('.modal-representante').leanModal({
               dismissible: false, // Modal can be dismissed by clicking outside of the modal
               opacity: .5, // Opacity of modal background
               in_duration: 300, // Transition in duration
               out_duration: 200, // Transition out duration
               starting_top: '2%', // Starting top style attribute
               ending_top: '2%', // Ending top style attribute
            });

       });

       $(document).ready(function () {
           // para ventana modal de busqueda
           $('.modal-search').leanModal({
               dismissible: false, // Modal can be dismissed by clicking outside of the modal
               opacity: .5, // Opacity of modal background
               in_duration: 300, // Transition in duration
               out_duration: 200, // Transition out duration
               starting_top: '4%', // Starting top style attribute
               ending_top: '4%', // Ending top style attribute
           });
       });

       $(function(){

           //prevenir que al dar enter se envie el formulario
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

       });



    </script>

    {{--Script para select dinamico condicional dropdown --}}
    <script src="{{ asset("js/dropdown.js") }}" type="text/javascript"></script>

@endsection