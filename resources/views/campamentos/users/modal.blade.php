    <div id="modal-delete-{{ $user->id }}" class="modal modal-fixed-footer" style="height: 35%; width: 55%">
        {{Form::open(array('action'=>array('UsersController@destroy',$user->id),'method'=>'delete'))}}
        <div class="modal-content">
            <div class="modal-header">
                 <h4>Eliminar Usuario<i class="material-icons waves-red darken-4 materialize-red-text right medium">warning</i></h4>
            </div>
            <p style="font-size: 120%">Confirme si desea eliminar al usuario <strong>{{$user->getNameAttribute()}}</strong></p>
            <p style="font-size: 110%; margin-left: 20%">! Esta acción no se podra deshacer ¡</p>
        </div>
        <div class="modal-footer">
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-red btn-flat','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-green btn-flat']) !!}
        </div>
        {{Form::Close()}}
    </div>

