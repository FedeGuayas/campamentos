@extends('layouts.admin.index')

@section('title','Listado de Trabajadores')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Listado de Trabajadores</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            @if ( Auth::user()->hasRole('administrator'))
                <a href="{{route('admin.users.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear usuario']) !!}
                </a>
            @endif
                <table id="trabajador_table" style="display: none" data-order='[[ 0, "asc" ]]'
                        class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Trabajador</th>
                    <th>Email</th>
                    <th>Roles</th>
                    <th>Pto Cobro</th>
                    <th>Opciones</th>
                    </thead>
                    <tfoot>
                    <tr>
                        <th>Id</th>
                        <th class="search-filter">Trabajador</th>
                        <th class="search-filter">Email</th>
                        <th class="search-filter">Roles</th>
                        <th class="search-filter">Pto Cobro</th>
                        <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @foreach ($trabajadores as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->getNameAttribute() }}</td>
                            <td>{{ $user->email }}</td>
                            <td>@foreach ($user->roles as $role)
                                    {{ $role->display_name }}<br>

                                @endforeach
                            </td>
                            <td>
                                {{$user->escenario['escenario']}}
                            </td>
                            <td>
                                @if ( Auth::user()->hasRole('administrator'))
                                <a href="{{ route('admin.trabajadores.edit', $user->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.users.show', $user->id ) }}">
                                    {!! Form::button('<i class="tiny fa fa-eye"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.users.roles', $user->id ) }}" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Roles">
                                    {!! Form::button('<i class="tiny fa fa-key"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$user->id"]) !!}
                                @endif
                            </td>
                        </tr>
                        @include ('campamentos.users.modal')
                    @endforeach
                    </tbody>
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')

    <script>
        $(document).ready(function () {

            // Agregar inputs de busquedad al datatble
            $('#trabajador_table .search-filter').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + title + '" />');
            });
            $('.materialboxed').materialbox();

            var table = $('#trabajador_table').DataTable({
                lengthMenu: [[5, 20, -1], [5, 20, "Todo"]],
                processing: true,
                stateSave: true,
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
                    $('#trabajador_table').fadeIn();

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

            $("select").val('5'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize
        });
    </script>

@endsection