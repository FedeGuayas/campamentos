@extends('layouts.admin.index')

@section('title','Reservas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Preinscripciones</h4>
        </div>
    </div>


<div class="row">
    <div class="col s6 right">
        {{--{!! Form::open(['route'=>'admin.alumnos.store', 'method'=>'POST','files'=>'true'])  !!}--}}
        {!! Form::open (['route' => 'admin.reserva.export',	'method' => 'POST', 'autocomplete'=> 'off', 'role' => 'search' ])!!}
        <ul class="collapsible popout" data-collapsible="accordion">
            <li>
                <div class="collapsible-header green accent-1"><i class="fa fa-file-excel-o"></i> <b>Exportar preinscripción</b></div>
                <div class="collapsible-body">
                    <div class="input-field col s4">
                        {!! Form::label('searchDesde','Desde') !!}
                        {!! Form::text('searchDesde',null,['class'=>'validate']) !!}
                    </div>
                    <div class="input-field col s4">
                        {!! Form::label('searchHata','Hasta') !!}
                        {!! Form::text('searchHata',null,['class'=>'validate']) !!}
                    </div>
                    <div class="input-field col s2">

                      {!!   Form::button('<i class="fa fa-file-excel-o" aria-hidden="true"></i>',['type'=>'submit', 'class'=>'btn-floating indigo waves-effect waves-light tooltipped', 'data-position'=>'top', 'delay'=>'50', 'data-tooltip'=>'Exportar']) !!}


                    </div>
                    <br><br><br><br>
                </div>
            </li>
        </ul>
        {!! Form::close() !!}
    </div>

</div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="inscripcion_table"
                   class="table table-striped table-bordered table-condensed table-hover highlight responsive-table"
                   cellspacing="0" width="100%" style="font-size: 10px;">
                <thead>
                <tr>
                    <th width="15px;">No.</th>
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    <th>Representante</th>
                    <th width="20px;">CI Rep.</th>
                    <th>Alumno</th>
                    <th>Valor</th>
                    <th>Creada</th>
                    <th width="50px">Vence</th>
                    <th>F. Pago</th>
                    <th width="55px;">Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="search-filter">No.</th>
                    <th class="search-filter">Escenario</th>
                    <th class="search-filter">Disciplina</th>
                    <th class="search-filter">Representante</th>
                    <th class="search-filter">CI Rep.</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                </tfoot>
                <tbody>

                @foreach ($inscripciones as $insc)
                    <tr>
                        <td>{{ sprintf("%'.05d",$insc->id) }}</td>
                        <td>{{ $insc->calendar->program->escenario->escenario }}</td>
                        <td>{{ $insc->calendar->program->disciplina->disciplina }}</td>
                        <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>
                        <td>{{ $insc->factura->representante->persona->num_doc }}</td>
                        <td>
                            @if ($insc->alumno_id == 0)
                                {{$insc->factura->representante->persona->getNombreAttribute()}}
                            @else
                                {{ $insc->alumno->persona->getNombreAttribute()}}
                            @endif
                        </td>
                        <td>$ {{ number_format($insc->factura->total, 2, '.', ' ') }}</td>
                        <td>{{$insc->created_at->diffForHumans()}}</td>
                        <td>{{ $insc->created_at->addDay()->toDateString() }}</td>
                        <td>
                            {{$insc->factura->pago->forma}}
                        </td>
                        <td>
                            @if ( Entrust::can('cancel_reserva'))
                                <a href="{{ route('admin.reserva.cancel', $insc->id ) }}" type="button"
                                   class="btn-xs white-text red darken-1 waves-effect waves-light tooltipped"
                                   data-position="top" delay="50" data-tooltip="Cancelar Reserva">
                                    <i class=" fa fa-trash" aria-hidden="true"></i>
                                </a>
                            @endif
                            @if ( Entrust::can('confirm_reserva'))
                                <a href="{{ route('admin.reserva.confirm', $insc->id ) }}" type="button"
                                   class="btn-xs white-text blue accent-3 waves-effect waves-light tooltipped"
                                   data-position="top" delay="50" data-tooltip="Aprobar Reserva">
                                    <i class="fa fa-check" aria-hidden="true"></i>
                                </a>
                                <a href="{{ route('admin.reserva.edit', [$insc->id] ) }}" type="button"
                                   class="btn-xs white-text teal darken-3 waves-effect waves-light tooltipped"
                                   data-position="top" delay="50" data-tooltip="Editar Forma Pago">
                                    <i class="fa fa-edit" aria-hidden="true"></i>
                                </a>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table><!--end table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>

        $(document).ready(function () {

            // Agregar inputs de busquedad al datatble
            $('#inscripcion_table .search-filter').each(function () {
                var title = $(this).text();
                $(this).html('<input type="text" placeholder="' + title + '" />');
            });


            var table = $('#inscripcion_table').DataTable({
                "lengthMenu": [[5, 10, 25], [5, 10, 25]],
                "processing": false,
                "language": {
                    "decimal": "",
                    "emptyTable": "No se encontraron datos en la tabla",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "infoFiltered": "(filtrados de un total _MAX_ registros)",
                    "infoPostFix": "",
                    "thousands": ",",
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
                    $('#inscripcion_table').fadeIn();
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
