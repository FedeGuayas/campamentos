@extends('layouts.admin.index')

@section('title','Inscripciones')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Inscripciones</h4>
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

            <table id="inscripcion_tabl" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%">
                <thead>
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
                <th>Valor</th>
                {{--<th>Opciones</th>--}}
                </thead>
                @foreach ($inscripciones as $insc)
                    <tr>
                        <td>{{ $insc->id }}</td>
                        <td>{{ $insc->alumno->persona->getNombreAttribute() }}</td>
                        <td>{{ $insc->alumno->persona->num_doc }}</td>
                        <td>{{ $insc->calendar->program->modulo->modulo }}</td>
                        <td>{{ $insc->calendar->program->escenario->escenario }}</td>
                        <td>{{ $insc->calendar->program->disciplina->disciplina }}</td>
                        <td>{{ $insc->calendar->dia->dia }}</td>
                        <td>{{ $insc->calendar->horario->start_time}}-{{ $insc->calendar->horario->end_time}}</td>
                        <td>{{ $insc->factura->representante->persona->getNombreAttribute() }}</td>
                        <td>{{ $insc->factura->representante->persona->num_doc }}</td>
                        <td>{{ $insc->factura->total }}</td>
                        {{--<td>--}}
                            {{--{!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$rep->id"]) !!}--}}
                            {{--<a href="{{ route('admin.representantes.edit', $rep->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                            {{--<a href="{{ route('admin.representantes.show', $rep->id ) }}">--}}
                                {{--{!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}--}}
                            {{--</a>--}}
                        {{--</td>--}}
                    </tr>
                @endforeach
            </table><!--end table-responsive-->
{{--            {{ $representantes->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {

            var table =  $('#inscripcion_table').DataTable({
                "lengthMenu": [[10, 25], [10, 25]],
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

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

    </script>
@endsection
