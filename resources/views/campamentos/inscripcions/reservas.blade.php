@extends('layouts.admin.index')

@section('title','Reservas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Reservas</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="inscripcion_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>No.</th>
                    {{--<th>Alumno</th>--}}
                    {{--<th>CI Al.</th>--}}
                    {{--<th>Mes</th>--}}
                    <th>Escenario</th>
                    <th>Disciplina</th>
                    {{--<th>Dias</th>--}}
                    {{--<th>Horarios</th>--}}
                    <th>Representante</th>
                    <th>CI Rep.</th>
                    <th>Valor</th>
                    <th>Creada</th>
                    <th>Vence</th>
                    <th>Opciones</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th class="search-filter">No.</th>
                    {{--<th>Alumno</th>--}}
                    {{--<th class="search-filter">CI Al.</th>--}}
                    {{--<th class="search-filter">Mes</th>--}}
                    <th class="search-filter">Escenario</th>
                    <th class="search-filter">Disciplina</th>
                    {{--<th>Dias</th>--}}
                    {{--<th>Horarios</th>--}}
                    <th>Representante</th>
                    <th>CI Rep.</th>
                    <th>Valor</th>
                    <th>Creada</th>
                    <th>Vence</th>
                    <th>Opciones</th>
                </tr>
                </tfoot>
                <tbody>

                @foreach ($inscripciones as $insc)
                    <tr>
                        <td>{{ sprintf("%'.05d",$insc->id) }}</td>
                        {{--<td>@if ($insc->alumno_id==0)--}}
                                {{--{{ $insc->factura->representante->persona->getNombreAttribute() }}--}}
                            {{--@else--}}
                                {{--{{ $insc->alumno->persona->getNombreAttribute() }}--}}
                            {{--@endif--}}
                        {{--</td>--}}
                        {{--<td>--}}
                            {{--@if ($insc->alumno_id==0)--}}
                                {{--{{ $insc->factura->representante->persona->num_doc }}--}}
                            {{--@else--}}
                            {{--{{ $insc->alumno->persona->num_doc }}--}}
                            {{--@endif--}}
                        {{--</td>--}}
                        {{--<td>{{ $insc->calendar->program->modulo->modulo }}</td>--}}
                        <td>{{ $insc->calendar->program->escenario->escenario }}</td>
                        <td>{{ $insc->calendar->program->disciplina->disciplina }}</td>
                        {{--<td>{{ $insc->calendar->dia->dia }}</td>--}}
                        {{--<td>{{ $insc->calendar->horario->start_time}}-{{ $insc->calendar->horario->end_time}}</td>--}}
                        <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>
                        <td>{{ $insc->factura->representante->persona->num_doc }}</td>
                        <td>$ {{ number_format($insc->factura->total, 2, '.', ' ') }}</td>
                        <td>{{$insc->created_at->diffForHumans()}}</td>
                        <td>{{ $insc->created_at }}</td>
                        <td>
                            @if ( Entrust::hasRole(['planner', 'administrator']))
                            <a href="{{ route('admin.reserva.cancel', $insc->id ) }}">
                            {!! Form::button('<i class="fa fa-ban" aria-hidden="true"></i>',['class'=>'btn-danger']) !!}
                            </a>
                            <a href="{{ route('admin.reserva.confirm', $insc->id ) }}">
                            {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'btn-success']) !!}
                            </a>
                            @endif
                        </td>
                    </tr>
                @include('campamentos.inscripcions.modal-delete')
                @endforeach
                </tbody>
            </table><!--end table-responsive-->
{{--            {{ $representantes->render() }}--}}
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
                "lengthMenu": [[5, 10, 25], [5, 10, 25]],
                "processing": false,
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

            $("select").val('5'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

    </script>
@endsection
