@extends('layouts.admin.index')

@section('title','Modulos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Modulos</h4>

            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                <a href="{{route('admin.modulos.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Modulo']) !!}
                </a>
                @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table"
                       id="modulo_table" style="display: none" data-order='[[ 0, "desc" ]]'>
                    <thead>
                    <th>Id</th>
                    <th>Nombre del Módulo</th>
                    <th>Fecha inicio</th>
                    <th>Fecha fin</th>
                    <th width="50">River ?</th>
                    <th>Estado (Hab/Des)</th>
                    <th>Opciones</th>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th class="search-filter">Modulo</th>
                        <th></th>
                        <th></th>
                        <th class="search-filter">SI/NO</th>
                        <th class="search-filter">Estado</th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($modulos as $modulo)
                        <tr>
                            <td>{{ $modulo->id }}</td>
                            <td>{{ $modulo->modulo }}</td>
                            <td>{{ $modulo->inicio }}</td>
                            <td>{{ $modulo->fin }}</td>
                            <td>
                                @if ($modulo->esRiver())
                                    <span class="text-danger">SI</span>
                                @else
                                    <span class="text-success">NO</span>
                                @endif
                            <td>
                                @if (($modulo->activated)=='1')
                                    <span class="label label-success">Activo</span>
                                    <a href="{{ route('admin.modulos.disable', $modulo->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light red darken-1']) !!}
                                    </a>

                                @else
                                    <span class="label label-danger">Inactivo</span>
                                    <a href="{{ route('admin.modulos.enable', $modulo->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                    </a>

                                @endif
                            </td>

                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.modulos.edit', $modulo->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Editar']) !!}
                                    </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1 tooltipped', 'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Eliminar', 'data-target'=>"modal-delete-$modulo->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.modulos.modal')
                    @endforeach
                    </tbody>
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection



@section('scripts')

    <script>
        $(document).ready(function () {

            // Agregar inputs de busquedad al datatble
            $('#modulo_table .search-filter').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + title + '" />');
            });
            $('.materialboxed').materialbox();

            var table = $('#modulo_table').DataTable({
                lengthMenu: [[10, 25, -1], [10, 25, "Todo"]],
                processing: true,
                stateSave: false,
                "language": {
                    "decimal": ",",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": " ",
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
                    $('#modulo_table').fadeIn();

                }
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize
        });
    </script>

@endsection