<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{asset('assets3/images/favicon.ico')}}" type="image/x-icon">
    <meta name="description" content="Sistema de facturacion de la Universidad Tecnologica de Candelaria">
    <title>@yield('title', env('APP_NAME'))</title>
    @include('auth.css')
    @stack('css')
  </head>
    <body class="sb-nav-fixed">
        @include ('components.header')  
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
            @include ('components.sidebar')
            </div>
            <div id="layoutSidenav_content">
                @yield('content')
                @include ('components.footer')
            </div>
        </div>
        @include('auth.script')
    </body>
    @stack('js')
</html>