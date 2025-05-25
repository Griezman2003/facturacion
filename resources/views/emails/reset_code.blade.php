<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Código de Recuperación</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            text-align: center;
        }
        .container {
            width: 100%;
            max-width: 500px;
            background: white;
            margin: 30px auto;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        }
        h2 {
            color: #333;
        }
        p {
            font-size: 16px;
            color: #666;
        }
        .code {
            font-size: 24px;
            font-weight: bold;
            color: #007bff;
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-top: 10px;
        }
        .footer {
            font-size: 12px;
            color: #888;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Recuperación de Contraseña</h2>
        <p>Hola,</p>
        <p>Recibiste este correo porque solicitaste restablecer tu contraseña.</p>
        <p>Tu código de verificación es:</p>
        <div class="code">{{ $code }}</div>
        <p>Si no solicitaste este código, puedes ignorar este mensaje.</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Universidad Tecnologica de Candelaria. Todos los derechos reservados.</p>
        </div>
    </div>
</body>
</html>