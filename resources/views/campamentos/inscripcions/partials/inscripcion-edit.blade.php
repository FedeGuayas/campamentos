    <div class="card-content">
        {!! Form::model($inscripcion,['route'=>['admin.inscripcions.update',$inscripcion->id], 'method'=>'PUT'])  !!}
        {!! Form::hidden('calendar_id',null,['id'=>'calendar_id']) !!} {{--actual--}}
        {!! Form::hidden('curso_guardado',null,['id'=>'curso_guardado']) !!} {{--curso guardado k se va a editar--}}
        {!! Form::hidden('program_id',null,['id'=>'program_id']) !!}
        {!! Form::hidden('descuento_empleado',null,['id'=>'descuento_empleado']) !!}{{-- Capturo si es empleado--}}
        {!! Form::hidden('descuento_estacion',null,['id'=>'descuento_estacion']) !!} {{-- Capturo la estacion actual--}}
        {!! Form::hidden('tipo_inscripcion',$tipo_inscripcion,['id'=>'tipo_inscripcion']) !!} {{--sencilla o multiple--}}
        {!! Form::hidden('descuento_factura',$descuento,['id'=>'descuento_factura']) !!} {{--descuento aplicado a la factura--}}
        {!! Form::hidden('costo_inscripcion',$costo_inscripcion,['id'=>'costo_inscripcion']) !!} {{--matricula + mesualidad de inscripcion actual--}}
        {!! Form::hidden('user_id',Auth::user()->id) !!}
        @include('alert.request')
        @include('alert.success')
        <div class="row">
            {{--<div class="col l6"><br>--}}
            <div class="col l6 m6 s10">
                {!! Form::label('representante', 'Representante:*') !!}
                {!! Form::text('representante',$representante,['readonly','required']) !!}
                {!! Form::hidden('representante_id',$representante_id,['id'=>'representante_id']) !!}
            </div>

            <div class="col l2">
                <div class="input-field disabled">
                    <i class="fa fa-usd prefix" aria-hidden="true"></i>
                    {!! Form::label('costo_anterior','Costo') !!}
                    {!! Form::number('costo_anterior',$costo_anterior,['style'=>'font-size: large','readonly', 'id'=>'costo_anterior' ]) !!}
                </div>
            </div>
            <div class="col l3 m3 s6 ">
                <i class="fa fa-calendar-check-o fa-2x teal-text" aria-hidden="true"></i>
                {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione Modulo','id'=>'modulo_id']) !!}
                {!! Form::label('modulo_id','Modulo:') !!}
            </div>
        </div>

        <div class="row">
            <div class="alumno">
                <div class="col l6">
                    {!! Form::label('alumno', 'Alumno:*') !!}
                    {!! Form::text('alumno',$alumno,['readonly','required']) !!}
                    {!! Form::hidden('alumno_id',$alumno_id,['id'=>'alumno_id']) !!}
                </div>
            </div>
            <div class="col l4 right">
                {!! Form::text('estacion',null,['id'=>'estacion', 'class'=>'hidden']) !!}
            </div>
        </div>

        <div class="row">
            <div class="col l4">
                <div class="input-field">
                    {!! Form::select('escenario_id',['placeholder'=>'Seleccione ...'],null,['id'=>'escenario_id','required']) !!}
                    {!! Form::label('escenario_id', 'Escenarios:*') !!}
                </div>
            </div>
            <div class="col l4">
                <div class="input-field">
                    {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'disciplina_id']) !!}
                    {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
                </div>
            </div>
            <div class="col l4">
                <div class="input-field">
                    {!! Form::select('dia_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'dia_id']) !!}
                    {!! Form::label('dia_id', 'Dias:*') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col l4">
                <div class="input-field">
                    {!! Form::select('horario_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'horario_id']) !!}
                    {!! Form::label('horario_id', 'Horario (Edades):*') !!}
                </div>
            </div>
            <div class="input-field  col l3 ">
                {!! Form::select('nivel',['placeholder' => 'Seleccione...'],null,['class'=>'validate','id'=>'nivel']) !!}
                {!! Form::label('nivel','Nivel:') !!}
            </div>
            <div class="col l3">
                <div class="input-field">
                    {!! Form::select('fpago_id',$fpagos,null, ['placeholder'=>'Seleccione ...'], ['id'=>'fpago_id']) !!}
                    {!! Form::label('fpago_id', 'Forma de pago:*') !!}
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('matricula',null,false,['id'=>'matricula']) !!}
                    {!! Form::label('matricula','Matricula') !!}
                </div>
            </div>

            <div class="col l2 m2 s2">
                <div class="input-field disabled">
                    <i class="fa fa-usd prefix" aria-hidden="true"></i>
                    {!! Form::label('valor','Valor:') !!}
                    {!! Form::number('valor',null,['placeholder'=>'0.00','style'=>'font-size: large','readonly', 'class'=>'valor' ]) !!}
                </div>
            </div>
        </div>


    </div><!--/.card content-->
    <div class="card-action">
        <div class="row">
            <div class="col l10 offset-l2">
                {!! Form::button('<i class="fa fa-close right" aria-hidden="true"></i> Cancelar',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'10', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}
                {!! Form::button('Actualizar<i class="fa fa-play right"></i>', ['class'=>'btn waves-effect waves-light','type' => 'submit']) !!}
                <a href="{{ route('admin.inscripcions.index') }}"  class="tooltipped" data-position="top" data-delay="50" data-tooltip="Regresar">
                    {!! Form::button('<i class="fa fa-undo"></i>',['class'=>'btn waves-effect waves-light darken-1']) !!}
                </a>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

