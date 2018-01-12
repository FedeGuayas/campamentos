@extends('layouts.admin.index')

@section('title','Inscripciones Eliminadas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            @include('alert.request')
            <h4>Inscripciones Eliminadas</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="inscripcion_table"
                   class="table table-striped table-bordered table-condensed table-hover highlight responsive-table"
                   cellspacing="0" width="100%" style="display: none" data-order='[[ 0, "desc" ]]'>
                <thead>
                <tr>
                    <th>No. Registro</th>
                    <th>Comprobante</th>
                    <th>Fecha inscripción</th>
                    <th>Fecha eliminación</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No. Registro</th>
                    <th>Comprobante</th>
                    <th>Fecha inscripción</th>
                    <th>Fecha eliminación</th>
                </tr>
                </tfoot>

            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->
    <input type="hidden" name="_token" value="{{csrf_token()}}" id="token">
    <div> <input type="hidden" id="insc_delete"></div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function () {

            var table = $('#inscripcion_table').DataTable({
                lengthMenu: [[5, 10, 15], [5, 10, 15]],
                processing: true,
                stateSave: false,
                serverSide: true,
                ajax: '{{route('admin.inscripcions.deletes')}}',
                columns: [
                    {data: 'id' },
                    {data: 'factura_id'},
                    {data: 'created_at'},
                    {data: 'deleted_at'}
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
                    $('#inscripcion_table').fadeIn();

                    table.columns().every(function () {
                        var column = this;
                        var columnClass = column.footer().className;
                        if(columnClass != 'non_searchable'){
                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                                    .on('change', function () {//keypress keyup
                                        column.search($(this).val(), false, false, true).draw();
                                    });
                        }
                    });
                }
            });

            $("select").val('5'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

        function eliminar(btn) {

            var id = btn.value;
            var token = $("#token").val();
            var route = "inscripcion/delete/"+id+"";

            swal({
                        title: "Confirme para eliminar?",
                        text: "Seguro que quiere eliminar la inscripción?. Esta acción no se podrá deshacer!",
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
                            setTimeout(function ()
                            {
                                $.ajax({
                                    url: route,
                                    type: "GET",
                                    headers: {'X-CSRF-TOKEN': token},
                                    contentType: 'application/x-www-form-urlencoded',
                                    dataType:'json',
                                    success: function (response) {
                                        swal("Confirmado!", response.resp,"success");
                                        $('#inscripcion_table').DataTable().draw();
                                    },
                                    error: function (resp) {
                                        console.log('Error al eliminar con ajax');
                                    }
                                });
//                        swal("Respuesta ajax");
                            },2000);
                        }//isConfirm
                        else {
                            swal("Cancelado", "Canceló la eliminación de la inscripcióm :)", "error");
                        }
                    });
        }



    </script>
@endsection
