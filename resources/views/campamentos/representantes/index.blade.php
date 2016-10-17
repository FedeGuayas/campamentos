@extends('layouts.admin.index')

@section('title','Representantes')

{{--@section('head')--}}
    {{--{!! Html::style('plugins/datatables/dataTables.bootstrap.css') !!}--}}
{{--@endsection--}}

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Representantes</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col l12 m12 s12">

                <a href="{{route('admin.representantes.create')}}">
                    {!! Form::button('<i class="fa fa-user-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light','data-position'=>'right', 'data-delay'=>'50', 'data-tooltip'=>'Crear representante']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Nombres y Apellidos</th>
                    <th>Identificación</th>
                    <th>Tipo</th>
                    <th>Género</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($representantes as $rep)
                        <tr>
                            <td>{{ $rep->id }}</td>
                            <td>{{ $rep->persona->getNombreAttribute() }}</td>
                            <td>{{ $rep->persona->num_doc }}</td>
                            <td>{{ $rep->persona->tipo_doc }}</td>
                            <td>{{ $rep->persona->genero }}</td>
                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$rep->id"]) !!}
                                <a href="{{ route('admin.representantes.edit', $rep->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.representantes.show', $rep->id ) }}">
                                    {!! Form::button('<i class="fa fa-eye"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                                <a href="{{ route('admin.alumnos.create' ) }}">
                                    {!! Form::button('<i class="fa fa-child" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>

                            </td>
                        </tr>
                        @include ('campamentos.representantes.modal')
                    @endforeach
                </table><!--end table-responsive-->
            {{--  {{ $usuarios->render() }}--}}
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection

{{--@section('scripts')--}}
    {{--{!! Html::script('plugins/datatables/jquery.dataTables.js') !!}--}}
    {{--{!! Html::script('plugins/datatables/dataTables.bootstrap.js') !!}--}}

    {{--<script type="text/javascript">--}}
        {{--$(document).ready( function () {--}}



            {{--$('#representantes').DataTable({--}}
                {{--processing: true,--}}
                {{--serverSide: true,--}}
                {{--select: true,--}}
                {{--ajax: '{!! route('admin.representantes.data') !!}',--}}
                {{--columns: [--}}
                    {{--{ data: 'id', name: 'id' },--}}
                    {{--{ data: 'persona_id', name: 'name' },--}}
                    {{--{ data: 'encuesta_id', name: 'email' },--}}
                    {{--{ data: 'phone', name: 'created_at' },--}}
                    {{--{ data: 'foto_ced', name: 'updated_at' },--}}
                    {{--{ data: 'foto', name: 'updated_at' },--}}
                    {{--{ data: 'foto_ced', name: 'updated_at' }--}}
                {{--]--}}
            {{--});--}}

        {{--} );--}}
    {{--</script>--}}
{{--@endsection--}}
