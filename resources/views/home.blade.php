@extends('layouts.front.master')

@section('title','Perfil')

@section('encabezado')
    {{Auth::user()->getNameAttribute()}}
@endsection

@section('content')
    <div class="col l12">
        <div class="card-panel">
            <ul class="tabs">
                <li class="tab col s3 "><a class="active" href="#perfil"><h6><i class="fa fa-user-secret"
                                                                                aria-hidden="true"></i> Perfil</h6></a>
                </li>
                <li class="tab col s3"><a href="#representante"><h6><i class="fa fa-registered" aria-hidden="true"></i>
                            Representante</h6></a></li>
                <li class="tab col s3"><a href="#alumnos" id="getCurso"><h6><i class="fa fa-users"
                                                                               aria-hidden="true"></i> Alumnos</h6></a>
                </li>
                <li class="tab col s3 "><a href="#inscripciones"><h6><i class="fa fa-pencil-square-o"
                                                                        aria-hidden="true"></i> Inscripciones</h6></a>
                </li>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col  s12">
            @include('alert.request')
            @include('alert.success')
            <div class="card-panel">
                <div id="perfil" class="animated fadeIn">
                    @include('online.users.profile.perfil')
                </div>
                <div id="representante">
                    <div class="animated fadeIn" data-wow-delay="0.4s">
                        @include('online.users.profile.representante')
                    </div>
                </div>
                <div id="alumnos">
                    <div class="animated fadeIn" data-wow-delay="0.4s">
                        @include('online.users.profile.alumno')
                    </div>
                </div>
                <div id="inscripciones">
                    <p class="animated fadeIn" data-wow-delay="0.4s">Inscripciones</p><br>
                </div>
            </div><!--/.card panel-->
        </div><!--/.card col-->
    </div><!--/.row-->
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">


@endsection

@section('scripts')
    <script>

        $(document).ready(function () {


            //llamar a funcion editar perfil de usuario
            $("#edit_user").on("click", function (event) {
                event.preventDefault();
                edit_user();
            });


        });


        $(document).ready(function () {
            $('.modal').modal({
                        dismissible: false, // Modal can be dismissed by clicking outside of the modal
                        opacity: .5, // Opacity of modal background
                        inDuration: 300, // Transition in duration
                        outDuration: 200, // Transition out duration
                        startingTop: '4%', // Starting top style attribute
                        endingTop: '10%', // Ending top style attribute
//                    ready: function(modal, trigger) { //Callback for Modal open. Modal and trigger parameters available.
//                        alert("Ready");
//                        console.log(modal, trigger);
//                    },
//                    complete: function() { alert('Closed'); } // Callback for Modal close
                    }
            );

        });

        function edit_user() {
            var id = "{{Auth()->user()->id}}";
            var token = $("input[name=_token]").val();
            var formData = new FormData(document.getElementById("form_edit_user"));
            var route = "{{route('user.update','id')}}";

            swal({
                title: "Confirme la actualización",
                text: "Se actualizarán su datos de usuario de nuestro sitio!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "SI!",
                cancelButtonText: " NO!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    setTimeout(function () {
                        $.ajax({
                            url: route.replace('id', id),
                            type: "POST",
                            headers: {'X-CSRF-TOKEN': token},
//                             contentType: 'application/x-www-form-urlencoded',
//                             dataType:'json',
                            data: formData,
                            cache: false,
                            contentType: false,
                            processData: false,
                            success: function (response) {
                                swal("", response.message, "success");
                            },
                            error: function (response) {
                                var errors = '';
                                $.each(response.responseJSON, function (ind, elem) {
                                    errors +=  '"'+elem+'"' +'\n';
                                });
                                swal("Error!", errors, "error");
                            }
                        });
                    }, 2000);
                    $(".sa-confirm-button-container .confirm").on('click', function () {
//                        $("#perfil").load(location.href + " #perfil");
                            window.setTimeout(function(){location.reload()},1)
                    });
                }//isConfirm
                else {
                    swal("Cancelado", "Canceló la edición de sus datos :)", "error");
                }
            });
        }


        function delete_representante(btn) {
            var id = btn.value;
//            var route = "inscripcion/delete/"+id+"";
            var token = $("input[name=_token]").val();
            var route = "{{route('user.representante.destroy','id')}}";
            swal({
                title: "Confirme para eliminar?",
                text: "Seguro que quiere eliminar al representante?. Esta acción no se podrá deshacer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "SI!",
                cancelButtonText: " NO!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    setTimeout(function () {
                        $.ajax({
                            url: route.replace('id', id),
                            type: "GET",
                            headers: {'X-CSRF-TOKEN': token},
                            contentType: 'application/x-www-form-urlencoded',
                            dataType:'json',
                            success: function (response) {
                                swal("", response.resp, "success");
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });
                    }, 2000);
                    $(".sa-confirm-button-container .confirm").on('click', function () {
//                        $("#perfil").load(location.href + " #perfil");
                        window.setTimeout(function(){location.reload()},1)
                    });
                }//isConfirm
                else {
                    swal("Cancelado", "Cancelo la eliminación del representante :)", "error");
                }
            });
        }


        function delete_alumno(btn) {
            var id = btn.value;
            var token = $("input[name=_token]").val();
            var route = "{{route('user.alumno.destroy','id')}}";
            swal({
                title: "Confirme para eliminar?",
                text: "Seguro que quiere eliminar al alumno?. Esta acción no se podrá deshacer!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "SI!",
                cancelButtonText: " NO!",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true,
            }, function (isConfirm) {
                if (isConfirm) {
                    setTimeout(function () {
                        $.ajax({
                            url: route.replace('id', id),
                            type: "GET",
                            headers: {'X-CSRF-TOKEN': token},
                            contentType: 'application/x-www-form-urlencoded',
                            dataType:'json',
                            success: function (response) {
                                swal("", response.resp, "success");
                            },
                            error: function (response) {
                                console.log(response);
                            }
                        });
                    }, 2000);
                    $(".sa-confirm-button-container .confirm").on('click', function () {
//                        $("#perfil").load(location.href + " #perfil");
                        window.setTimeout(function(){location.reload()},1)
                    });
                }//isConfirm
                else {
                    swal("Cancelado", "Cancelo la eliminación del alumno :)", "error");
                }
            });
        }






    </script>
@endsection