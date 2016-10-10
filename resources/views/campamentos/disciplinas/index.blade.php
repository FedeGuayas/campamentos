@extends('layouts.admin.index')

@section('title','Disciplinas')

@section('content')

    <div class="row">
        <div class="col l8 m8 s">
            @include('alert.success')
            <h4>Disciplinas</h4>
            {{-- @include('runner.usuarios.search')--}}
        </div>
    </div>

    <div class="row">
        <div class="col s12">
            <div class="">
                <a href="{{route('admin.disciplinas.create')}}">
                    {!! Form::button('<i class="fa fa-plus" ></i>',['class'=>'btn tooltipped waves-effect waves-light', 'data-position'=>'right','data-delay'=>'50','data-tooltip'=>'Crear Disciplina']) !!}
                </a>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Disciplina</th>
                    <th>Estado (Hab/Des)</th>
                    <th>Opciones</th>
                    </thead>
                    @foreach ($disciplinas as $dis)
                        <tr>
                            <td>{{ $dis->id }}</td>
                            <td>{{ $dis->disciplina }}</td>
                            <td>
                                @if (($dis->activated)===1)
                                    <span class="label label-success">Activo</span>
                                    <a href="{{ route('admin.disciplinas.disable', $dis->id)}}">
                                        {!! Form::button('<i class="fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light red darken-1']) !!}
                                    </a>
                                @else
                                    <span class="label label-danger">Inactivo</span>
                                    <a href="{{ route('admin.disciplinas.enable', $dis->id)}}">
                                        {!! Form::button('<i class="tiny fa fa-check" aria-hidden="true"></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                    </a>
                                @endif
                            </td>

                            <td>
                                {!! Form::button('<i class="fa fa-trash-o" ></i>',['class'=>'modal-trigger btn-floating waves-effect waves-light red darken-1','data-target'=>"modal-delete-$dis->id"]) !!}
                                <a href="{{ route('admin.disciplinas.edit', $dis->id ) }}">
                                    {!! Form::button('<i class="fa fa-pencil-square-o" ></i>',['class'=>'btn-floating waves-effect waves-light teal darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                        @include ('campamentos.disciplinas.modal')
                    @endforeach
                </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection