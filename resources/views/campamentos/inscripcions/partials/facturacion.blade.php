{!! Form::open(['class'=>'form_noEnter', 'id'=>'form_otra_facturacion'])  !!}
<div class="row">

    <h5 class="teal-text">Facturar a :</h5>
    <div class="input-field col s12">

        {!! Form::checkbox('otro_factura',null,false,['id'=>'otro_factura']) !!}
        {!! Form::label('otro_factura','Otros datos para facturacion') !!}
    </div>
</div>

<div class="row">

    <div class="input-field col s12 m6">
        {!! Form::text('fact_nombres',null,['class'=>'fact_nombres validate','required','readonly','style'=>'text-transform:uppercase']) !!}
        {!! Form::label('fact_nombres','Nombres:*') !!}
    </div>
    <div class="input-field col s12 m6">
        {!! Form::number('fact_ci',null,['class'=>'fact_ci validate','required','readonly','onkeypress'=>"if (this.value.length > 9 ) {return false}"]) !!}
        {!! Form::label('fact_ci','CI:*') !!}
    </div>

    <div class="input-field col s12 m6">
        {!! Form::email('fact_email',null,['class'=>'fact_email validate','required','readonly','style'=>'text-transform:lowercase']) !!}
        {!! Form::label('fact_email','Correo:*') !!}
    </div>
    <div class="input-field col s12 m6">
        {!! Form::text('fact_phone',null,['class'=>'fact_phone validate','required','readonly']) !!}
        {!! Form::label('fact_phone','Teléfono1:*') !!}
    </div>

    <div class="input-field col s12 m8">
        {!! Form::textarea('fact_direccion',null,['class'=>'materialize-textarea fact_direccion validate','required','readonly','length'=>'255','style'=>'text-transform:uppercase']) !!}
        {!! Form::label('fact_direccion','Dirección:*') !!}
    </div>
    <div class="input-field col s12 m3 disabled right">
        <i class="fa fa-usd prefix" aria-hidden="true"></i>
            {!! Form::number('valor',null,['placeholder'=>'0.00','style'=>'font-size: large','readonly', 'class'=>'valor']) !!}
            {!! Form::label('valor','Total:') !!}
    </div>

</div>

{!! Form::close() !!}


