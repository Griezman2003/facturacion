<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets3/images/favicon.ico')}}" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', env('APP_NAME'))</title>
    <style>
        .custom-bg {
            background-color: #ddd;
        }
        .grosorLetra{
            font-weight: 600
        }
        .hr{
            background-color: blue;
            height: 5px;
        }
        @media print{
            #no-print {
                display: none;
            }
        }
    </style>
</head>
<body id="page-top">
    @include('auth.css')
    @include('auth.script')
    @yield('contenido')
</body>
</html>