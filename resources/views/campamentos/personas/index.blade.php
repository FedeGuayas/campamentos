@extends('layouts.admin.index')

@section('title','Personas')

{{--@section('head')--}}
    {{--{!! Html::style('plugins/datatables/dataTables.bootstrap.css') !!}--}}
{{--@endsection--}}

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Personas</h4>
        </div>
    </div>
    <div class="row">
        <div class="col l12 m12 s12">

                <table id="persona_table" class="table table-striped table-bordered table-condensed table-hover highlight responsive-table" cellspacing="0" width="100%" style="display: none"  data-order='[[ 0, "asc" ]]'>
                    <thead>
                    <th>Id</th>
                    <th>Nombres y Apellidos</th>
                    <th>Tipo Doc</th>
                    <th>Doc</th>
                    <th>Genero</th>
                    <th>Fecha Nac</th>
                    <th>Email</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Opcion</th>
                    </thead>
                    @foreach ($personas as $per)
                        <tr>
                            <td>{{ $per->id }}</td>
                            <td>{{ $per->getNombreAttribute() }}</td>
                            <td>{{ $per->tipo_doc }}</td>
                            <td>{{ $per->num_doc }}</td>
                            <td>{{ $per->genero }}</td>
                            <td>{{ $per->fecha_nac }}</td>
                            <td>{{ $per->email }}</td>
                            <td>{{ $per->direccion }}</td>
                            <td>{{ $per->telefono }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$per->id"]) !!}
                                {{--agregar como representante--}}

                                <a href="{{ route('persona.representante',$per->id ) }}">
                                    {!! Form::button('<i class="fa fa-child" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>

                            </td>
                        </tr>
                        @include ('campamentos.personas.modal')
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

@section('scripts')
    <script>
        $(document).ready( function () {

            var table =  $('#persona_table').DataTable({
                "lengthMenu": [[10, 25], [10, 25]],
                "processing": true,
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
                    $('#persona_table').fadeIn();
                }
            });

            $("select").val('10'); //seleccionar valor por defecto del select
            $('select').addClass("browser-default"); //agregar una clase de materializecss de esta forma ya no se pierde el select de numero de registros.
            $('select').material_select(); //inicializar el select de materialize

        });

    </script>
@endsection
