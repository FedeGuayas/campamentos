    <div class="row">
        <div class="col l12 col m6 col s12  ">
            <h5 class="teal-text">Facturar a :</h5>

            <div class="row">
                <div class="col l10 offset-l2">
                    <div class="col l8">
                            {!! Form::label('fact_nombres','Nombres:*') !!}
                            {!! Form::text('fact_nombres',null,['class'=>'fact_nombres','required','readonly']) !!}
                        </div>

                </div>
            </div>
            <div class="row">
                <div class="col l10 offset-l2">
                    <div class="col l5 m5 s12">
                        <i class="fa fa-envelope prefix"></i>
                        {!! Form::label('fact_email','Correo:*') !!}
                        {!! Form::email('fact_email',null,['class'=>'fact_email','readonly']) !!}
                    </div>
                    <div class="col l5 m5 s6">
                        <i class="fa fa-phone prefix"></i>
                        {!! Form::label('fact_phone','Teléfono1:*') !!}
                        {!! Form::text('fact_phone',null,['class'=>'fact_phone','readonly']) !!}

                    </div>
                    <div class="col l10 m10 s12">
                        <i class="fa fa-pencil prefix"></i>
                        {!! Form::label('fact_direccion','Dirección*:') !!}
                        {!! Form::text('fact_direccion',null,['class'=>'materialize-textarea fact_direccion','readonly']) !!}
                    </div>
                </div>
            </div>
            <div class="col l2 m2 s2 right">
                <div class="input-field disabled">
                    <i class="fa fa-usd prefix" aria-hidden="true"></i>
                    {!! Form::label('valor','Total:') !!}
                    {!! Form::number('valor',null,['placeholder'=>'0.00','style'=>'font-size: large','readonly', 'class'=>'valor']) !!}
                </div>
            </div>
        </div>
    </div>


