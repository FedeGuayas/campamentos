<html>
<body>

<div><hr>
    <p>
        Click en el siguiente link para recuperar su contraseña en el sistema de Campamentos Deportivos de FEDEGUAYAS.
    </p>
        Recuperar contraseña : <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
</div>
</body>
</html>




