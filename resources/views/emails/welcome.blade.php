<!DOCTYPE html>
<html>
<head>
    <title>¡Bienvenido al equipo {{ config('app.name') }}!</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background-color: #4285f4; /* Google-like blue */
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            line-height: 1.6;
        }
        .content h1 {
            color: #4285f4;
            font-size: 22px;
            margin-bottom: 20px;
        }
        .content p {
            margin: 0 0 15px;
        }
        .credentials-box {
            background-color: #f1f3f4; /* Light grey background */
            color: #333;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
            margin: 20px 0;
            line-height: 1.4;
        }
        .footer {
            text-align: center;
            color: #777;
            font-size: 12px;
            padding: 20px;
            background-color: #f1f3f4;
        }
        .footer img {
            max-width: 150px;
            height: auto;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <h1>¡Bienvenido al equipo {{ config('app.name') }}!</h1>
        </div>
        <div class="content">
            <h1>Hola, {{ $usuario->nombres }} {{ $usuario->apellidoP }}</h1>
            <p>Estamos emocionados de que te unas a nuestra plataforma. A continuación, encontrarás tus credenciales de inicio de sesión:</p>
            <div class="credentials-box">
                <p><strong>Email:</strong> {{ $usuario->email }}</p>
                <p><strong>Contraseña:</strong> {{ $password }}</p>
            </div>
            <p>Por favor, inicia sesión y cambia tu contraseña después de iniciar sesión por primera vez para garantizar la seguridad de tu cuenta.</p>
        </div>
        <div class="footer">
            <p>Saludos,<br>El equipo de {{ config('app.name') }}</p>
            <img src="{{ $message->embed(public_path('assets/img/procesa.png')) }}" alt="Logo">
        </div>
    </div>
</body>
</html>
