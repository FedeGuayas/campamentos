<div class="card-content">
    {!! Form::open(['route'=>'admin.inscripcions.store', 'method'=>'POST', 'class'=>'form_noEnter', 'id'=>'form_inscripcion'])  !!}
    {!! Form::hidden('calendar_id',null,['id'=>'calendar_id']) !!}
    {!! Form::hidden('program_id',null,['id'=>'program_id']) !!}
    {!! Form::hidden('descuento_empleado',null,['id'=>'descuento_empleado']) !!}{{-- Capturo si es empleado--}}
    {!! Form::hidden('descuento_estacion',null,['id'=>'descuento_estacion']) !!} {{-- Capturo la estacion actual--}}
    {!! Form::hidden('user_id',Auth::user()->id) !!}
    {{--{!! Form::hidden('precio',null,['id'=>'precio']) !!}--}}
    @include('alert.request')
    @include('alert.success')
    <div class="row">
        {{--<div class="col l6"><br>--}}
        <div class="input-field col l6 m6 s10">
            {!! Form::select('representante_id',['placeholder'=>'Seleccione ...'],null,['id'=>'representante_id','required']) !!}
            {!! Form::label('representante_id', 'Representante:*') !!}
        </div>

        <div class="pull-left" style="position: relative; display: inline-block;">
            <div class="fixed-action-btn horizontal click-to-toggle"
                 style="position: relative; display: inline-block; right: 24px; ">
                <a class="btn-floating btn-medium teal"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                <ul>
                    <li>
                        <a href="#modal-search" type="button"
                           class="btn-floating red waves-effect waves-light tooltipped modal-search" data-position="top"
                           delay="50" data-tooltip="Buscar"
                        ><i class="fa fa-search"></i>
                        </a>
                    </li>
                    <li>
                        <a href="#modal-representante" type="button"
                           class="btn-floating blue waves-effect waves-light tooltipped modal-representante"
                           data-position="top" data-delay="50" data-tooltip="Crear"
                           style="transform: scaleY(0.4) scaleX(0.4) translateY(0px) translateX(40px); opacity: 0;"><i
                                    class="fa fa-plus"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="col l2">
            <div class="input-field">
                {!! Form::checkbox('adulto',null,false,['id'=>'adulto']) !!}
                {!! Form::label('adulto','Inscribir') !!}
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
                {!! Form::select('alumno_id',['placeholder'=>'Seleccione ...'],null,['id'=>'alumno_id']) !!}
                {!! Form::label('alumno_id', 'Alumno:*') !!}
            </div>
            <div class="pull-left" style="position: relative; display: inline-block;">
                <div class="fixed-action-btn horizontal"
                     style="position: relative; display: inline-block; right: 24px; ">
                    <a href="#modal-alumno" type="button"
                       class="btn-floating  waves-effect waves-light darken-1 tooltipped modal-alumno"
                       data-position="top" data-delay="50" data-tooltip="Crear">
                        <i class="fa fa-plus"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="col l4 right">
            {!! Form::text('estacion',null,['id'=>'estacion', 'class'=>'hidden']) !!}
        </div>
    </div>

    <div class="row">
        <div class="col l4">
            <div class="input-field">
                {{--{!! Form::select('escenario_id', '$escenarios',null, ['id'=>'escenario_id']) !!}--}}
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
                {!! Form::checkbox('familiar',null,false,['id'=>'familiar']) !!}
                {!! Form::label('familiar','Familiar (10%)') !!}
            </div>
        </div>
        <div class="col l2">
            <div class="input-field">
                {!! Form::checkbox('primo',null,false,['id'=>'primo']) !!}
                {!! Form::label('primo','Primos (5%)') !!}
            </div>
        </div>
        <div class="col l2">
            <div class="input-field">
                {!! Form::checkbox('multiple',null,false,['id'=>'multiple','class'=>'multiple','disabled']) !!}
                {!! Form::label('multiple','Multiple',['class'=>'multiple']) !!}
            </div>
        </div>
        <div class="col l2">
            <div class="input-field">
                {!! Form::checkbox('matricula',null,false,['id'=>'matricula']) !!}
                {!! Form::label('matricula','Matricula') !!}
            </div>
        </div>
        @if (Entrust::hasRole(['admin-cortesia']))
            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('cortesia',null,false,['id'=>'cortesia']) !!}
                    {!! Form::label('cortesia','Cortesia') !!}
                </div>
            </div>
            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('presidente',null,false,['id'=>'presidente']) !!}
                    {!! Form::label('presidente','Presidente') !!}
                </div>
            </div>
        @endif

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
            {{--<a href="{{route('product.addToCart',['id'=>$product->id])}}">--}}
            <a href="{{route('inscripciones.addMultiples',':CALENDAR')}}" id="add-cursos">
                {!! Form::button('<i class="fa fa-plus"></i>', ['class'=>'btn waves-effect waves-light tooltipped agregar','disabled','data-position'=>'top', 'data-delay'=>'10', 'data-tooltip'=>'Agregar']) !!}
            </a>
            {{--{!! Form::checkbox('reservar',null,false,['id'=>'reservar']) !!}--}}
            {{--{!! Form::label('reservar','Reserva') !!}--}}

            {!! Form::button('<i class="fa fa-close right" aria-hidden="true"></i> Cancelar',['class'=>'btn waves-effect waves-light red darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'10', 'data-tooltip'=>'Cancelar','type' => 'reset']) !!}

            {{--<a href="#!" >--}}
            {!! Form::button('<i class="fa fa-play right" aria-hidden="true"></i> Aplicar',['id'=>'pagar','disabled','class'=>'btn waves-effect waves-light darken-1 tooltipped','data-position'=>'top', 'data-delay'=>'50', 'data-tooltip'=>'Aceptar','type'=>'submit']) !!}
            {{--</a>--}}
        </div>
    </div>
    {!! Form::close() !!}
    @include('campamentos.inscripcions.partials.representante_create')
    @include('campamentos.inscripcions.partials.alumno_create')
    {{--Busca el represenatnte --}}
    @include('campamentos.alumnos.search')

</div>

