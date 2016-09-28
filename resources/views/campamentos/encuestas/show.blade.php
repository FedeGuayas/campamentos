@extends('layouts.admin.index')

@section('title', 'Encuesta')

@section('content')

    <div class="row">
        <div class="col s12">
            <div>
                <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                    <thead>
                    <th>Id</th>
                    <th>Encuesta</th>
                    <th>Contador</th>
                    <th>Opciones</th>
                    </thead>
                        <tr>
                            <td>{{ $encuesta->id }}</td>
                            <td>{{ $encuesta->encuesta }}</td>
                            <td>{{ $encuesta->contador }}</td>
                            <td>
                                <a href="{{ route('admin.encuestas.index') }}">
                                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                                </a>
                            </td>
                        </tr>
                  </table><!--end table-responsive-->
            </div><!-- end div ./table-responsive-->
        </div><!--end div ./col-lg-12. etc-->
    </div><!--end div ./row-->

@endsection