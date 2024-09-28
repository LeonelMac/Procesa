<!DOCTYPE html>
<html>

<head>
    <title>Restablecimiento de Contraseña</title>
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
            background-color: #4285f4;
            /* Google-like blue */
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

        .content p {
            margin: 0 0 15px;
        }

        .password-box {
            background-color: #f1f3f4;
            /* Light grey background */
            color: #333;
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
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
            <h1>Restablecimiento de Contraseña</h1>
        </div>
        <div class="content">
            <p>Hola {{ $usuario->nombres }} {{ $usuario->apellidoP }} {{ $usuario->apellidoM }}.</p>
            <p>Su contraseña ha sido restablecida exitosamente. Su nueva contraseña es:</p>
            <div class="password-box">
                {{ $nuevaPassword }}
            </div>
            <p>Le recomendamos encarecidamente cambiar esta contraseña una vez que inicie sesión para mantener la
                seguridad de su cuenta.</p>
        </div>
        <div class="footer">
            <p>Saludos<br>del equipo de {{ config('app.name') }}</p>
            <img src="{{ $message->embed(public_path('assets/img/procesa.png')) }}" alt="Logo">
        </div>
    </div>
</body>

</html>
