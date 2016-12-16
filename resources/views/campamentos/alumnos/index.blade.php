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
            <table id="alumnos_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "asc" ]]'>
                <thead>
                <tr>
                    <th width="50">Id</th>
                    <th width="150">Nombres</th>
                    <th width="150">Apellidos</th>
                    <th width="90">Identificación</th>
                    <th width="80">Tipo</th>
                    <th width="90">Género</th>
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
                    <th>Opciones</th>
                </tr>
                </tfoot>

                {{--<div class="preloader-wrapper big active hidden">--}}
                    {{--<div class="spinner-layer spinner-blue">--}}
                        {{--<div class="circle-clipper left">--}}
                            {{--<div class="circle"></div>--}}
                        {{--</div><div class="gap-patch">--}}
                            {{--<div class="circle"></div>--}}
                        {{--</div><div class="circle-clipper right">--}}
                            {{--<div class="circle"></div>--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}

{{--                        @include ('campamentos.alumnos.modal')--}}


                </table><!--end table-responsive-->



        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')

    <script>
        $(document).ready( function () {
            // Agregar inputs de busquedad al datatble
//            $('#alumnos_table .search-filter').each( function () {
//                var title = $(this).text();
//                $(this).html( '<input type="text" placeholder="'+title+'" />' );
//            } );

            var table =  $('#alumnos_table').DataTable({
                lengthMenu: [[10, 25], [10, 25]],
                processing: true,
                stateSave: true,
                serverSide:true,
                ajax: '{{route('admin.alumnos')}}',
                columns: [
                    {data: 'id', name: 'alumnos.id'},
                    {data: 'persona.nombres', name: 'persona.nombres'},
                    {data: 'persona.apellidos', name: 'persona.apellidos'},
                    {data: 'persona.num_doc', name: 'persona.num_doc'},
                    {data: 'persona.tipo_doc', name: 'persona.tipo_doc', orderable: false, searchable: false},
                    {data: 'persona.genero', name: 'persona.genero', orderable: false, searchable: false},
                    {data: 'actions', name: 'actions'}
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

                            var input = document.createElement("input");
                            $(input).appendTo($(column.footer()).empty())
                                    .on('keyup change', function () {
                                        column.search($(this).val(), false, false, true).draw();
                                    });

                        });

                }
            });

//            // Apply the search
//            table.columns().every( function () {
//                var that = this;
//                $( 'input', this.footer() ).on( 'keyup change', function () {
//                    if ( that.search() !== this.value ) {
//                        that.search( this.value ).draw();
//                    }
//                } );
//            } );

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize
        });
    </script>


@endsection