    <div id="modal-delete-{{ $hora->id }}" class="modal modal-fixed-footer" style="height: 45%">
        {!! Form::open(['route'=>['admin.horarios.destroy',$hora->id],'method'=>'delete']) !!}
        <div class="modal-content">
            <div>
                 <h3>Eliminar Horario<i class="fa fa-warning waves-red darken-4 materialize-red-text right medium"></i></h3>
            </div>
            <p >Confirme si desea eliminar el horario <strong>"{{$hora->start_time.' - '.$hora->end_time}}"</strong></p>
            <p >! Esta acción no se podra deshacer ¡</p>
        </div>
        <div class="modal-footer">
            {!! Form::button('Aceptar',['class'=>'waves-effect waves-red btn-flat','type'=>'submit']) !!}
            {!! Form::button('Cancelar',['class'=>'modal-action modal-close waves-effect waves-green btn-flat']) !!}
        </div>
        {!! Form::close() !!}
    </div>

