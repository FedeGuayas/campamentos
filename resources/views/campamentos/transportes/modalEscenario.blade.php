    <div id="modal-delete-{{ $escenario->id }}" class="modal modal-fixed-footer" style="height: 45%">
        {!! Form::open(['route'=>['admin.transportes.destroyEscenario',$transporte->id,$escenario->id],'method'=>'delete']) !!}
        {{--{!! Form::hidden() !!}--}}
        <div class="modal-content">
            <div>
                 <h3>Desvincular el escenario del transporte<i class="fa fa-warning waves-red darken-4 materialize-red-text right medium"></i></h3>
            </div>
            <p >Confirme si desea proseguir   <strong></strong></p>
            <p >! Esta acción no se podra deshacer ¡</p>
        </div>
        <div class="modal-footer">
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-red btn-flat','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-green btn-flat']) !!}
        </div>
        {!! Form::close() !!}
    </div>

