@extends('layouts.admin.index')

@section('title','Representantes')

{{--@section('head')--}}
    {{--{!! Html::style('plugins/datatables/dataTables.bootstrap.css') !!}--}}
{{--@endsection--}}

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Representantes</h4>
            @if ( Auth::user()->can('create_representante'))
                <a href="{{route('admin.representantes.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear representante']) !!}
                </a>
            @endif
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            <div class="table-responsive">
                <table id="representante_table" class="table table-striped table-bordered table-condensed table-hover highlight" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "desc" ]]'>
                    <thead>
                    <tr>
                        <th width="40">Id</th>
                        <th width="130">Nombres</th>
                        <th width="130">Apellidos</th>
                        <th width="70">CI</th>
                        <th width="90">Canton</th>
                        <th width="220">Alumno</th>
                        <th width="70">CI. A</th>
                        <th width="70">Opciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>CI</th>
                        <th width="90" class="non_searchable">Canton</th>
                        <th class="non_searchable">Alumno</th>
                        <th class="non_searchable">CI. A</th>
                        <th class="non_searchable">Opciones</th>
                    </tr>
                    </tfoot>
                </table><!--end table-responsive-->
            </div>

        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {

            var table =  $('#representante_table').DataTable({
                lengthMenu: [[10, 25], [10, 25]],
                processing: true,
                stateSave: false,
                serverSide:true,
                ajax: '{{route('admin.representantes')}}',
                columns: [
                    {data: 'id', name: 'representantes.id'},
                    {data: 'persona.nombres', name: 'persona.nombres'},
                    {data: 'persona.apellidos', name: 'persona.apellidos'},
                    {data: 'persona.num_doc', name: 'persona.num_doc'},
                    {data: 'canton' ,orderable: false, searchable: false},
                    {data: 'alumnos', name: 'alumnos.persona',orderable: false,  searchable: false},
                    {data: 'ci', name: 'alumnos.ci',orderable: false,  searchable: false},
                    {data: 'actions', name: 'actions',orderable: false, searchable: false}
                ],
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
                    $('#representante_table').fadeIn();


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

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

    </script>
@endsection
