<html>
    <body>
    <div>Estimado: <b>{{$user->getNameAttribute()}}</b><hr>
        Este email le ha llegado porque se ha creado una cuenta en el sistema de Campamentos Deportivos de FEDEGUAYAS.
        <p>El siguiente link le permitirá activar  su cuenta para poder acceder al sistema. Este enlace será de un solo uso.
        </p>
        Activar su cuenta : {{$link}}



    </div>
    </body>
</html>