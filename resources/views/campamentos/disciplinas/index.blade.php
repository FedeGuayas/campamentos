@extends('layouts.admin.index')

@section('title','Disciplinas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Disciplinas</h4>
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                @if ( Auth::user()->hasRole(['planner','administrator']))
                    <a href="{{route('admin.disciplinas.create')}}">
                        {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Disciplina']) !!}
                    </a>
                @endif
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table"
                       id="disciplina_table" style="display: none" data-order='[[ 0, "desc" ]]'>
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Disciplina</th>
                        <th>Estado (Hab/Des)</th>
                        <th>Opciones</th>
                    </tr>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th class="search-filter">Disciplina</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($disciplinas as $dis)
                        <tr>
                            <td>{{ $dis->id }}</td>
                            <td>{{ $dis->disciplina }}</td>
                            <td>
                                @if (($dis->activated)=='1')
                                    <span class="label label-success">Activo</span>
                                    <a href="{{ route('admin.disciplinas.disable', $dis->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light red darken-1']) !!}
                                    </a>
                                @else
                                    <span class="label label-danger">Inactivo</span>
                                    <a href="{{ route('admin.disciplinas.enable', $dis->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                @endif
                            </td>

                            <td>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                    <a href="{{ route('admin.disciplinas.edit', $dis->id ) }}">
                                        {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Editar']) !!}
                                    </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Eliminar','data-target'=>"modal-delete-$dis->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.disciplinas.modal')
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
            $('#disciplina_table .search-filter').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + title + '" />');
            });
            $('.materialboxed').materialbox();

            var table = $('#disciplina_table').DataTable({
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
                    $('#disciplina_table').fadeIn();

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