@extends('layouts.admin.index')

@section('title','Alumnos')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Alumnos</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

           @if ( Auth::user()->can('create_alumno'))
                <a href="{{route('admin.alumnos.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear alumno']) !!}
                </a>
            @endif
                {{--<table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">--}}
            <table id="alumnos_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "asc" ]]'>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Nombres y Apellidos</th>
                    <th>Identificación</th>
                    <th>Tipo</th>
                    <th>Género</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th class="search-filter">Nombres y Apellidos</th>
                    <th class="search-filter">Identificación</th>
                    <th>Tipo</th>
                    <th>Género</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>
                    @foreach ($alumnos as $al)
                        <tr>
                            <td>{{ $al->id }}</td>
                            <td>{{ $al->persona->getNombreAttribute() }}</td>
                            <td>{{ $al->persona->num_doc }}</td>
                            <td>{{ $al->persona->tipo_doc }}</td>
                            <td>{{ $al->persona->genero }}</td>
                            <td>
                                @if ( Auth::user()->can('delete_alumno'))
                                    {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$al->id"]) !!}
                                @endif

                                @if ( Auth::user()->can('edit_alumno'))
                                    <a href="{{ route('admin.alumnos.edit', $al->id ) }}">
                                        {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                @endif
                                <a href="{{ route('admin.alumnos.show', $al->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                        @include ('campamentos.alumnos.modal')
                    @endforeach
                </tbody>
                </table><!--end table-responsive-->
{{--              {{ $alumnos->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')

    <script>
        $(document).ready( function () {
            // Agregar inputs de busquedad al datatble
            $('#alumnos_table .search-filter').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );

            var table =  $('#alumnos_table').DataTable({
                lengthMenu: [[10, 25, -1], [10, 25, "Todo"]],
                processing: true,
                stateSave: true,
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

                }
            });

            // Apply the search
            table.columns().every( function () {
                var that = this;
                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that.search( this.value ).draw();
                    }
                } );
            } );

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize
        });
    </script>


@endsection