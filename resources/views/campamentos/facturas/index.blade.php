@extends('layouts.admin.index')

@section('title','Facturas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Comprobantes de Pago</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="comprobantes_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Valor</th>
                    <th>Descuento</th>
                    <th>Inscripción</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>No.</th>
                    <th>Valor</th>
                    <th>Descuento</th>
                    <th>Inscripción</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {

            var table =  $('#comprobantes_table').DataTable({
                lengthMenu: [[10, 25], [10, 25]],
                processing: true,
                stateSave: true,
                serverSide:true,
                ajax: '{{route('admin.facturas')}}',
                columns: [
                    {data: 'id', name: 'facturas.id'},
                    {data: 'total', name: 'facturas.total'},
                    {data: 'descuento', name: 'facturas.descuento'},
                    {data: 'inscripcion', name: 'inscripcions.id'},
                    {data: 'actions', name: 'opciones',orderable: false, searchable: false}
                ],
                "order" : [0,'desc'],
                "language":{
                    "decimal":        "",
                    "emptyTable":     "No se encontraron datos en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      ",",
                    "lengthMenu":     "Mostrar _MENU_ registros",
                    "loadingRecords": "Cargando...",
                    "processing":     "Procesando...",
                    "search":         "Buscar:",
                    "zeroRecords":    "No se encrontraron coincidencias",
                    "paginate": {
                        "first":      "Primero",
                        "last":       "Ultimo",
                        "next":       "Siguiente",
                        "previous":   "Anterior"
                    },
                    "aria": {
                        "sortAscending":  ": Activar para ordenar ascendentemente",
                        "sortDescending": ": Activar para ordenar descendentemente"
                    }
                },
                "fnInitComplete":function(){
                    $('#comprobantes_table').fadeIn();

                    table.columns().every(function () {
                        var column = this;

                        var input = document.createElement("input");
                        $(input).appendTo($(column.footer()).empty())
                                .on('keyup change', function () {
                                    column.search($(this).val(), false, false, true).draw();
                                });
                    });
                }
            });

            $("select").val('5');
            $('select').addClass("browser-default");
            $('select').material_select();

        });



    </script>
@endsection
