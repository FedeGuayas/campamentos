@extends('layouts.admin.index')

@section('title','Alumnos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Alumnos</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            @if ( Auth::user()->can('create_alumno'))
                <a href="{{route('admin.alumnos.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear alumno']) !!}
                </a>
            @endif
            <div class="table-responsive">
                <table id="alumnos_table" class="table table-striped table-bordered table-condensed table-hover highlight" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "desc" ]]'>
                    <thead>
                    <tr>
                        <th width="50">Id</th>
                        <th width="150">Nombres</th>
                        <th width="150">Apellidos</th>
                        <th width="90">Identificación</th>
                        <th width="80">Tipo</th>
                        <th width="90">Género</th>
                        <th width="90">Canton</th>
                        <th width="90">Opciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Identificación</th>
                        <th >Tipo</th>
                        <th >Género</th>
                        <th class="non_searchable"></th>
                        <th class="non_searchable"></th>
                    </tr>
                    </tfoot>

                    {{--@include ('campamentos.alumnos.modal')--}}

                </table><!--end table-responsive-->

            </div>


        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')

    <script>
        $(document).ready( function () {

            var table =  $('#alumnos_table').DataTable({
                lengthMenu: [[10, 25,50], [10, 25,50]],
                processing: true,
                stateSave: true,
                serverSide:true,
                ajax: '{{route('admin.alumnos')}}',
                columns: [
                    {data: 'id', name: 'alumnos.id'},
                    {data: 'persona.nombres', name: 'persona.nombres'},
                    {data: 'persona.apellidos', name: 'persona.apellidos'},
                    {data: 'persona.num_doc', name: 'persona.num_doc'},
                    {data: 'persona.tipo_doc', name: 'persona.tipo_doc', orderable: false},
                    {data: 'persona.genero', name: 'persona.genero', orderable: false},
                    {data: 'canton' ,orderable: false, searchable: false},
                    {data: 'actions', name: 'opciones',orderable: false, searchable: false}
                ],
                "language":{
                    "decimal":        ",",
                    "emptyTable":     "No se encontraron datos en la tabla",
                    "info":           "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty":      "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered":   "(filtrados de un total _MAX_ registros)",
                    "infoPostFix":    "",
                    "thousands":      " ",
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
                    $('#alumnos_table').fadeIn();

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

            $("select").val('10');
            $('select').addClass("browser-default");
            $('select').material_select();
        });
    </script>


@endsection