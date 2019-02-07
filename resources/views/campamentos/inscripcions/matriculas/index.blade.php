@extends('layouts.admin.index')

@section('title','Matriculas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            @include('alert.request')
            <h4>Matrículas pagadas posterior a la inscripción</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="matricula_table"
                   class="table table-striped table-bordered table-condensed table-hover highlight "
                   cellspacing="0" width="100%" style="display: none" data-order='[[ 0, "desc" ]]'>
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Inscripción No.</th>
                    <th>Comprobante</th>
                    <th>Modulo</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Dias</th>
                    <th>Representante</th>
                    <th>CI Rep.</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Inscripción</th>
                    <th>Comprobante</th>
                    <th class="non_searchable">Modulo</th>
                    <th class="non_searchable">Escenario</th>
                    <th class="non_searchable">Disciplina</th>
                    <th class="non_searchable">Dias</th>
                    <th class="non_searchable">Representante</th>
                    <th class="non_searchable">CI Rep.</th>
                    <th class="non_searchable">Opciones</th>
                </tr>
                </tfoot>

            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div><input type="hidden" id="ins_delete"></div>

    <div id="loader_page">
        <div class="preloader-wrapper big active">
            <div class="spinner-layer spinner-blue">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-red">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-yellow">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
            <div class="spinner-layer spinner-green">
                <div class="circle-clipper left">
                    <div class="circle"></div>
                </div>
                <div class="gap-patch">
                    <div class="circle"></div>
                </div>
                <div class="circle-clipper right">
                    <div class="circle"></div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            var table = $('#matricula_table').on('processing.dt', function (e, settings, processing) {
                $('#loader_page').css('display', processing ? 'block' : 'none');
            }).DataTable({
                lengthMenu: [[5, 10, 15], [5, 10, 15]],
                processing: false,
                stateSave: false,
                serverSide: true,
                ajax: '{{route('admin.matriculas')}}',
                columns: [
                    {data: 'id'},
                    {data: 'inscripcion_id'},
                    {data: 'factura_id'},
                    {data: 'modulo', name: 'modulo', orderable: false, searchable: false},
                    {data: 'inscripcion.calendar.program.escenario.escenario', name: 'inscripcion.calendar.program.escenario.escenario', orderable: false, searchable: false},
                    {data: 'inscripcion.calendar.program.disciplina.disciplina', name: 'inscripcion.calendar.program.disciplina.disciplina', orderable: false, searchable: false},
                    {data: 'inscripcion.calendar.dia.dia', name: 'inscripcion.calendar.dia.dia', orderable: false, searchable: false},
                    {data: 'representante', name: 'representante', orderable: false, searchable: false},
                    {data: 'factura.representante.persona.num_doc', name: 'factura.representante.persona.num_doc', orderable: false, searchable: false},
//                    {data: 'inscripcion.calendar.program.modulo.modulo', name: 'modulo'}
                    {data: 'actions', orderable: false, searchable: false}
                ],
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "No se encrontraron coincidencias",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                    "aria": {
                        "sortAscending": ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete": function () {
                    $('#matricula_table').fadeIn();

                    table.columns().every(function () {
                        var column = this;
                        var columnClass = column.footer().className;
                        if (columnClass != 'non_searchable') {
                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                                .on('change', function () {//keypress keyup
                                    column.search($(this).val(), false, false, true).draw();
                                });
                        }
                    });
                }
            });

            $("select").val('5');
            $('select').addClass("browser-default");
            $('select').material_select();

        });

        function eliminar(btn) {

            var id = btn.value;
            var token = $("#token").val();
            var route = "inscripcion/delete/" + id + "";

            swal({
                    title: "Confirme para eliminar?",
                    text: "Seguro que quiere eliminar la matricula?. Esta acción no se podrá deshacer!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "SI!",
                    cancelButtonText: " NO!",
                    closeOnConfirm: false,
                    closeOnCancel: false,
                    showLoaderOnConfirm: true,
                },
                function (isConfirm) {
                    if (isConfirm) {
                        setTimeout(function () {
                            $.ajax({
                                url: route,
                                type: "GET",
                                headers: {'X-CSRF-TOKEN': token},
                                contentType: 'application/x-www-form-urlencoded',
                                dataType: 'json',
                                success: function (response) {
                                    swal("Confirmado!", response.resp, "success");
                                    $('#inscripcion_table').DataTable().draw();
                                },
                                error: function (resp) {
                                    console.log('Error al eliminar con ajax');
                                }
                            });
//                        swal("Respuesta ajax");
                        }, 2000);
                    }//isConfirm
                    else {
                        swal("Cancelado", "Canceló la eliminación de la inscripcióm :)", "error");
                    }
                });
        }


    </script>
@endsection
