    <div class="card-content">
        {!! Form::open(['route'=>'admin.inscripcions.store', 'method'=>'POST'])  !!}

        <div class="row">
            <div class="col l6"><br>
                {!! Form::select('representante_id', ['Repre' => 'Representante'],null, ['id'=>'representante_id']) !!}
            </div>
            <div class="pull-left" style="position: relative; display: inline-block;">
                <div class="fixed-action-btn horizontal" style="position: relative; display: inline-block; right: 24px; ">
                    <a class="btn-floating btn-medium teal"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
                    <ul>
                        <li>
                            <a href="#!" class="btn-floating waves-effect waves-light darken-1 tooltipped" data-position="top" data-delay="50" data-tooltip="Buscar"
                               style="transform: scaleY(0.4) scaleX(0.4) translateY(0px) translateX(40px); opacity: 0;"><i class="fa fa-search"></i>
                            </a>
                        </li>
                        <li>
                            <a href="#!" class="btn-floating  waves-effect waves-light darken-1 tooltipped" data-position="top" data-delay="50" data-tooltip="Crear"
                               style="transform: scaleY(0.4) scaleX(0.4) translateY(0px) translateX(40px); opacity: 0;"><i class="fa fa-plus"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col l3 m4 s6 offset-l2 ">
                <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                {!! Form::select('modulo_id', ['modul1' => 'Enero', 'mod2' => 'Febrero'],null, ['id'=>'modulo_id']) !!}
                {!! Form::label('modulo_id','Modulo:') !!}
            </div>
        </div>

        <div class="row">
            <div class="col l6">
                {!! Form::select('alumno_id', ['Al' => 'Alumno'],null, ['id'=>'alumno_id']) !!}
            </div>
            <a href="#!" class="tooltipped" data-position="top" data-delay="50" data-tooltip="Crear">
                {!! Form::button('<i class="fa fa-plus"></i>',['class'=>'btn-floating waves-effect waves-light darken-1']) !!}
            </a>
        </div>

        <div class="row">
            <div class="col l6">
                <div class="input-field">
                    {{--{!! Form::select('escenario_id', '$escenarios',null, ['id'=>'escenario_id']) !!}--}}
                    {!! Form::select('escenario_id', ['Esc' => 'Escenarios'],null, ['id'=>'escenario_id']) !!}
                    {!! Form::label('escenario_id', 'Escenarios:*') !!}
                </div>
            </div>
            <div class="col l6">
                <div class="input-field">
                    {!! Form::select('disciplina_id', ['Disc' => 'Disc'],null, ['id'=>'disciplina_id']) !!}
                    {!! Form::label('disciplina_id', 'Disciplinas:*') !!}
                </div>
            </div>

            <div class="col l6">
                <div class="input-field">
                    {!! Form::select('dia_id', ['Dia' => 'Diass'],null, ['id'=>'dia_id']) !!}
                    {!! Form::label('dia_id', 'Dias:*') !!}
                </div>
            </div>
            <div class="col l6">
                <div class="input-field">
                    {!! Form::select('horario_id', ['Hor' => 'Horas'],null, ['id'=>'horario_id']) !!}
                    {!! Form::label('horario_id', 'Horario:*') !!}
                </div>
            </div>

            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('desc_10',null,false,['id'=>'desc_10']) !!}
                    {!! Form::label('desc_10','Desc 10%') !!}
                </div>
            </div>
            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('desc_50',null,false,['id'=>'desc_50']) !!}
                    {!! Form::label('desc_50','Desc 50%') !!}
                </div>
            </div>
            <div class="col l2">
                <div class="input-field">
                    {!! Form::checkbox('matricula',null,false,['id'=>'matricula']) !!}
                    {!! Form::label('matricula','Matricula') !!}
                </div>
            </div>
            <div class="col l4">
                <div class="input-field">
                    {!! Form::select('fpago_id', ['Fpago' => 'F pago'],null, ['id'=>'fpago_id']) !!}
                    {!! Form::label('fpago_id', 'Forma de pago:*') !!}
                </div>
            </div>
            <div class="col l2">
                <div class="input-field">
                    <i class="fa fa-usd prefix" aria-hidden="true"></i>
                    {!! Form::label('anticipo','Anticipo:') !!}
                    {!! Form::number('anticipo',null,['step' => '0.01','min' => '1','class'=>'validate','placeholder'=>'0.00']) !!}
                </div>
            </div>
        </div>

    </div><!--/.card content-->
    <div class="card-action">
        <div class="row">
            <div class="col l6 offset-l6">
                <a href="{{route('product.addToCart',['id'=>$product->id])}}">
                    {!! Form::button('<i class="fa fa-plus"></i>', ['class'=>'btn waves-effect waves-light']) !!}
                </a>

                {!! Form::button('<i class="fa fa-close"></i>',['class'=>'btn waves-effect waves-light red darken-1','type' => 'reset']) !!}
                <a href="#!">
                    {!! Form::button('<i class="fa fa-money" aria-hidden="true"></i>',['class'=>'btn btn-large pull-right waves-effect waves-light darken-1','type' => 'submit']) !!}
                </a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

