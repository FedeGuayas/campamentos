<div class="col l12">

    {!! Form::model($inscripcion,['route'=>['admin.inscripcions.update',$inscripcion->id], 'method'=>'PUT'])  !!}
    {!! Form::hidden('inscripcion_id',$inscripcion->id,['id'=>'inscripcion_id']) !!}
    {!! Form::hidden('costo_actual',$costo_actual,['id'=>'costo_actual']) !!}
    {!! Form::hidden('edad',$edad,['id'=>'edad']) !!}
    <div class="row">

        <div class="card-panel">
            {{--<h5 class="header teal-text text-darken-2">Calendario:</h5>--}}
            <div class="card-content ">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title ">Curso Actual</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered table-condensed table-hover highlight responsive-table">
                            <thead>
                            <tr>
                                <th>Escenario</th>
                                <th>Disciplina</th>
                                <th>Dias</th>
                                <th>Horarios</th>
                                <th>Costo</th>
                                <th>Edad/Año de nacimiento</th>
                            </tr>
                            </thead>
                            <tr>
                                <td>{{$curso_actual->program->escenario->escenario}}</td>
                                <td>{{$curso_actual->program->disciplina->disciplina}}</td>
                                <td>{{$curso_actual->dia->dia}}</td>
                                <td>{{$curso_actual->horario->start_time}}-{{ $curso_actual->horario->end_time}}</td>
                                <td>${{number_format($costo_actual,2,'.',' ')}}</td>
                                <td>{{$edad}}</td>

                            </tr>
                        </table>
                    </div>
                </div>
                <h6>Buscar:</h6>
                <div class="row">
                    {!! Form::open(['class'=>'form_noEnter', 'id'=>'form_curso']) !!}

                    <div class="input-field col s3 ">
                        {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione *','id'=>'modulo_id','required']) !!}
                        {!! Form::label('modulo_id','Modulo:') !!}
                        {{--{{Form::select('modulo',$moduloSelect,$modulo,['id'=>'modulo']) }}--}}
                    </div>
                    <div class="input-field col s2 ">
                        {!! Form::select('escenario_id',['placeholder'=>'Seleccione ...'],null,['id'=>'escenario_id','required']) !!}
                        {!! Form::label('escenario_id', 'Escenarios:*') !!}
                        {{--            {{Form::select('escenario',$escenarioSelect,$escenario,['id'=>'escenario']) }}--}}
                    </div>
                    <div class="input-field col s3 ">
                        {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'disciplina_id','required']) !!}
                        {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
                        {{--            {{Form::select('disciplina',$disciplinaSelect,$disciplina,['id'=>'disciplina']) }}--}}
                    </div>
                    <div class="input-field col s3 ">
                        {{--            {{Form::select('horario',$horarioSelect,$horario,['id'=>'horario']) }}--}}
                        {!! Form::select('horario_id[]', ['placeholder'=>'Seleccione ...'],null, ['id'=>'horario_id','multiple']) !!}
                        {!! Form::label('horario_id', 'Horario:') !!}
                    </div>
                    <div class="col s1 right">
                        <a href="#!" id="filtrar_curso">
                            {!! Form::button('<i class="fa fa-search left"></i>',['class'=>'btn-floating waves-effect waves-light blue darken-2 tooltipped','data-position'=>'top', 'data-delay'=>'50','data-tooltip'=>'Filtrar']) !!}
                        </a>
                    </div>
                    {!! Form::close() !!}
                </div>

            </div><!--/.card content-->

        </div>
        <div id="search-result"></div>
    </div>
    {!! Form::close() !!}

</div>
