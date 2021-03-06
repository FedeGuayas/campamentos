@extends('layouts.admin.index')

@section('title','Programación')

@section('head')
    {{--CSS--}}

@endsection

@section('content')
    {{--Contenido--}}
    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
                <h4>Programación para inscripciones</h4>
            @if (Auth::user()->hasRole(['planner','administrator']))
            <a href="{{route('admin.programs.create')}}">
                {!! Form::button('<i class="fa fa-plus left" aria-hidden="true"></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Nuevo programa']) !!}
            </a>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">
            <table id="program_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none"   data-order='[[ 0, "desc" ]]'>
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Modulo</th>
                    <th>Matricula</th>
                    <th>Estado (Hab/Des)</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th class="search-filter">Escenario</th>
                    <th class="search-filter">Disciplina</th>
                    <th class="search-filter">Modulo</th>
                    <th>Matricula</th>
                    <th>Estado (Hab/Des)</th>
                    <th>Imagen</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>
                @foreach ($programs as $program)
                    <tr>
                        <td>{{ $program->id }}</td>
                        <td>{{ $program->escenario}}</td>
                        <td>{{ $program->disciplina }}</td>
                        <td>{{ $program->modulo }}</td>
                        <td>$ {{ number_format($program->matricula, 2, '.', ' ') }}</td>
                        <td>
                            @if (($program->activated)=='1')
                                <span class="label label-success">Activo</span>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                <a href="{{ route('admin.programs.disable', $program->id)}}">
                                    {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label  waves-effect waves-light red darken-1']) !!}
                                </a>
                                @endif
                            @else
                                <span class="label label-danger">Inactivo</span>
                                @if ( Auth::user()->hasRole(['planner','administrator']))
                                <a href="{{ route('admin.programs.enable', $program->id)}}">
                                    {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}
                                </a>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if (!isset($program->imagen))
                                NO
                            @else
                                <img src="{{ asset('/img/camp/disciplinas/'.$program->imagen)}}" style='max-width: 50px;' class="responsive-img img-thumbnail materialboxed">
                            @endif
                        </td>
                        <td>
                            @if (Auth::user()->can('edit_program'))
                            <a href="{{ route('admin.programs.edit', $program->id ) }}">
                                {!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Editar',]) !!}
                            </a>
                            @endif
                            <a href="{{ route('admin.programs.show', $program->id ) }}">
                                {!! Form::button('<i class="tiny fa fa-eye"></i>',['class'=>'label waves-effect waves-light teal darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Mostrar',]) !!}
                            </a>
                            @if (Auth::user()->can('create_calendar'))
                            <a href="{{ route('admin.calendars.create',$program->id) }}">
                            {!! Form::button('<i class="tiny fa fa-calendar-plus-o" aria-hidden="true"></i>',['class'=>'label waves-effect waves-light teal darken-1 tooltipped',
                            'data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Calendario',]) !!}
                            </a>
                            @endif
                                @if (Auth::user()->can('delete_program'))
                                    {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Eliminar','data-target'=>"modal-delete-$program->id"]) !!}
                                @endif
                        </td>
                    </tr>
                    @include ('campamentos.programs.modal')
                @endforeach
                </tbody>
            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection


@section('scripts')

    <script>
        $(document).ready( function () {

       // Agregar inputs de busquedad al datatble
            $('#program_table .search-filter').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );
            $('.materialboxed').materialbox();

            var table =  $('#program_table').DataTable({
                lengthMenu: [[10, 25, -1], [10, 25, "Todo"]],
                processing: true,
                stateSave: false,
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
                    $('#program_table').fadeIn();

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