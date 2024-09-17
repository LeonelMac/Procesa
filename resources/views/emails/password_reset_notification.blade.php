<!DOCTYPE html>
<html>
<head>
    <title>Restablecimiento de Contraseña</title>
</head>
<body>
    <p>Hola {{ $usuario->nombres }} {{ $usuario->apellidoP }} {{ $usuario->apellidoM }},</p>
    <p>Su contraseña ha sido restablecida. Su nueva contraseña es:</p>
    <p><strong>{{ $nuevaPassword }}</strong></p>
    <p>Le recomendamos cambiar esta contraseña una vez que inicie sesión.</p>
    <p>Saludos.</p>
    <p>El equipo de {{ config('app.name') }}</p>
</body>
</html>
