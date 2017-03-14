@extends('layouts.admin.index')

@section('title','Inscripciones')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            @include('alert.request')
            <h4>Inscripciones</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="inscripcion_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>Alumno</th>
                    <th>CI Al.</th>
                    <th>Mes</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Dias</th>
                    <th>Horarios</th>
                    <th>Representante</th>
                    <th>CI Rep.</th>
                    <th>Nivel</th>
                    <th>Comprobante</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="search-filter">No.</th>
                    <th>Alumno</th>
                    <th class="search-filter">CI Al.</th>
                    <th class="search-filter">Mes</th>
                    <th class="search-filter">Escenario</th>
                    <th class="search-filter">Disciplina</th>
                    <th>Dias</th>
                    <th>Horarios</th>
                    <th>Representante</th>
                    <th>CI Rep.</th>
                    <th>Nivel</th>
                    <th>Comprobante</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>

                @foreach ($inscripciones as $insc)
                    <tr>
                        <td>{{ sprintf("%'.05d",$insc->id) }}</td>
                        <td>@if ($insc->alumno_id==0)
                                {{ $insc->factura->representante->persona->getNombreAttribute() }}
                            @else
                                {{ $insc->alumno->persona->getNombreAttribute() }}
                            @endif
                        </td>
                        <td>
                            @if ($insc->alumno_id==0)
                                {{ $insc->factura->representante->persona->num_doc }}
                            @else
                            {{ $insc->alumno->persona->num_doc }}
                            @endif
                        </td>
                        <td>{{ $insc->calendar->program->modulo->modulo }}</td>
                        <td>{{ $insc->calendar->program->escenario->escenario }}</td>
                        <td>{{ $insc->calendar->program->disciplina->disciplina }}</td>
                        <td>{{ $insc->calendar->dia->dia }}</td>
                        <td>{{ $insc->calendar->horario->start_time}}-{{ $insc->calendar->horario->end_time}}</td>
                        <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>
                        <td>{{ $insc->factura->representante->persona->num_doc }}</td>
                        <td>{{ $insc->calendar->nivel}}</td>
                        <td>{{ $insc->factura_id}}</td>
                        <td>
                            {{--@if ( ( Entrust::can('edit_inscripcion') ) || Entrust::hasRole('administrator') )--}}
                            {{--<a href="{{ route('admin.inscripcions.edit', $insc->id ) }}">--}}
                                {{--{!! Form::button('<i class="tiny fa fa-pencil-square-o" ></i>',['class'=>'label waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--@endif--}}
                            {{--<a href="{{ route('admin.inscripcions.show', $insc->id ) }}">
                                {!! Form::button('<i class="tiny fa fa-eye"></i>',['class'=>'label waves-effect waves-light blue darken-1']) !!}
                            </a>--}}
                            {{--@if (Auth::user()->id==$insc->user_id ||  Entrust::hasRole('administrator'))--}}
                            <a href="{{  route('admin.reports.pdf',$insc->id ) }}">
                                {!! Form::button('<i class="tiny fa fa-file-pdf-o"></i>',['class'=>'label waves-effect waves-light teal darken-1  orange accent-4']) !!}
                            </a>
                            {{--@endif--}}
                            @if (Entrust::can('delete_inscripcion'))
                                @if(Auth::user()->escenario_id==$insc->escenario_id ||  Entrust::hasRole('administrator'))
                            {!! Form::button('<i class="tiny fa fa-trash-o" ></i>',['class'=>'modal-trigger label waves-effect waves-light red darken-1','data-target'=>"modal-delete-$insc->id"]) !!}
                                @endif
                            @endif
                        </td>
                    </tr>
                @include('campamentos.inscripcions.modal-delete')
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
            $('#inscripcion_table .search-filter').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="'+title+'" />' );
            } );


            var table =  $('#inscripcion_table').DataTable({
                "lengthMenu": [[25,10,5], [25,10,5]],
                "processing": true,
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
                    $('#inscripcion_table').fadeIn();
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

            $("select").val('25'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

    </script>
@endsection
