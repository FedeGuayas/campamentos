<div class="card-content">
    {!! Form::open(['route'=>'admin.inscripcions.store', 'method'=>'POST', 'class'=>'form_noEnter', 'id'=>'form_inscripcion'])  !!}
    {!! Form::hidden('calendar_id',null,['id'=>'calendar_id']) !!}
    {!! Form::hidden('program_id',null,['id'=>'program_id']) !!}
    {!! Form::hidden('descuento_empleado',null,['id'=>'descuento_empleado']) !!}{{-- Capturo si es empleado--}}
    {!! Form::hidden('descuento_estacion',null,['id'=>'descuento_estacion']) !!} {{-- Capturo la estacion actual--}}
    {!! Form::hidden('user_id',Auth::user()->id) !!}
    {!! Form::hidden('matricula_river',null,['id'=>'matricula_river']) !!}
    @include('alert.request')
    @include('alert.success')

    <div class="row">

        <div class="input-field col s12 m8">
            {!! Form::select('representante_id',['placeholder'=>'Seleccione ...'],null,['id'=>'representante_id','class'=>'validate']) !!}
            {!! Form::label('representante_id', 'Representante:*') !!}
            <div class="right" style="position: relative;  top: -40px; right: -80px;">
                <div class="fixed-action-btn horizontal click-to-toggle" style="position: relative; ">
                    <a class="btn-floating btn-xs cyan"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                    <ul>
                        <li>
                            <a href="#modal-search" type="button"
                               class="btn-floating red waves-effect waves-light tooltipped modal-search" data-position="top" delay="50"
                               data-tooltip="Buscar" >
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#modal-representante" type="button"
                               class="btn-floating blue waves-effect waves-light tooltipped modal-representante" data-position="top" data-delay="50"
                               data-tooltip="Crear">
                                <i class="fa fa-plus"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="input-field col s12 m3 pull-right">
            {!! Form::checkbox('adulto',null,false,['id'=>'adulto']) !!}
            {!! Form::label('adulto','Insc. Adulto') !!}
        </div>

        <div class="input-field col s12 m8">
            <div class="alumno">
                {!! Form::select('alumno_id',['placeholder'=>'Seleccione ...'],null,['id'=>'alumno_id']) !!}
                {!! Form::label('alumno_id', 'Alumno:*') !!}
                <div class="pull-right" style="position: relative; display: inline-block; top: -65px; right: -50px;">
                    {{--<div class="fixed-action-btn horizontal" style="position: relative;">--}}
                        <a href="#modal-alumno" type="button"
                           class="btn-floating  purple waves-effect waves-light darken-1 tooltipped modal-alumno" data-position="top" data-delay="50"
                           data-tooltip="Crear">
                            <i class="fa fa-plus"></i>
                        </a>
                    {{--</div>--}}
                </div>
            </div>
        </div>


        <div class="input-field col s12 m6 ">
            {!! Form::select('modulo_id', $modulos,null, ['placeholder'=>'Seleccione ...','id'=>'modulo_id','class'=>'validate']) !!}
            {!! Form::label('modulo_id','Modulo:*') !!}
        </div>
        <div class="col s2">
            {!! Form::text('estacion',null,['id'=>'estacion', 'class'=>'hidden']) !!}
        </div>

        <div class="input-field col s12 m6">
                {!! Form::select('escenario_id',['placeholder'=>'Seleccione ...'],null,['id'=>'escenario_id']) !!}
                {!! Form::label('escenario_id', 'Escenarios:*') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('disciplina_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'disciplina_id','class'=>'validate']) !!}
            {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('dia_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'dia_id','class'=>'validate']) !!}
            {!! Form::label('dia_id', 'Dias:*') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('horario_id', ['placeholder'=>'Seleccione ...'],null, ['id'=>'horario_id','class'=>'validate']) !!}
            {!! Form::label('horario_id', 'Horario (Edades):*') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('nivel',['placeholder' => 'Seleccione...'],null,['class'=>'validate','id'=>'nivel']) !!}
            {!! Form::label('nivel','Nivel:') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('fpago_id',$fpagos,null,['id'=>'fpago_id','placeholder'=>'Seleccione ...','class'=>'validate']) !!}
            {!! Form::label('fpago_id', 'Forma de pago:*') !!}
        </div>

        <div class="input-field col s12 m6">
            {!! Form::select('descuento_id',$descuentos, null, ['id'=>'descuento_id','placeholder'=>'Seleccione ...','class'=>'validate']) !!}
            {!! Form::label('descuento_id', 'Descuento:') !!}
        </div>

    </div>



    <div class="row">


        <div class="input-field col s12 m6">
            <div class="">
                {!! Form::checkbox('matricula',null,false,['id'=>'matricula']) !!}
                {!! Form::label('matricula','Matricula') !!}
            </div>
        </div>

        <div class="input-field col s12 m3 disabled">
            <i class="fa fa-usd prefix" aria-hidden="true"></i>
            {!! Form::label('valor','Valor:') !!}
            {!! Form::number('valor',null,['placeholder'=>'0.00','style'=>'font-size: large','readonly', 'class'=>'valor' ]) !!}
        </div>

    </div>

    <div class="row">

        <div  class="col s8 right mensaje_membresia hide">
            <h6>
                <blockquote>
                    <p id="mensaje_membresia"></p>
                </blockquote>
            </h6>

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

