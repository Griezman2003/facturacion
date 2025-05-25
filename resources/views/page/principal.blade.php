<!DOCTYPE html>
<html class="wide wow-animation" lang="en">
<head>
  <title>Facturacion</title>
  <meta name="format-detection" content="telephone=no">
  <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta charset="utf-8">
  <link rel="icon" href="{{asset('assets3/images/favicon.ico')}}" type="image/x-icon">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Poppins:400,500,600%7CTeko:300,400,500%7CMaven+Pro:500">
  <link rel="stylesheet" href="{{asset('assets3/css/bootstrap.css')}}">
  <link rel="stylesheet" href="{{asset('assests3/css/fonts.css')}}">
  <link rel="stylesheet" href="{{asset('assets3/css/style.css')}}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <style>.ie-panel{display: none;background: #212121;padding: 10px 0;box-shadow: 3px 3px 5px 0 rgba(0,0,0,.3);clear: both;text-align:center;position: relative;z-index: 1;} html.ie-10 .ie-panel, html.lt-ie-10 .ie-panel {display: block;}</style>
</head>
<body>
  <div class="preloader">
    <div class="preloader-body">
      <div class="cssload-container"><span></span><span></span><span></span><span></span>
      </div>
    </div>
  </div>
  <div class="page">
    <div id="inicio">
      {{-- <a class="section section-banner text-center d-none d-xl-block" href="#home" style="background-image: url(images/banner/banner-bg-02-1920x60.jpg); background-image: -webkit-image-set( url(images/banner/banner-bg-02-1920x60.jpg) 1x, url(images/banner/banner-bg-02-3840x120.jpg) 2x )"><img src="images/banner/banner-fg-02-1600x60.png" alt="" width="1600" height="0"></a> --}}
      <header class="section page-header">
        <div class="rd-navbar-wrap">
          <nav class="rd-navbar rd-navbar-classic" data-layout="rd-navbar-fixed" data-sm-layout="rd-navbar-fixed" data-md-layout="rd-navbar-fixed" data-md-device-layout="rd-navbar-fixed" data-lg-layout="rd-navbar-static" data-lg-device-layout="rd-navbar-fixed" data-xl-layout="rd-navbar-static" data-xl-device-layout="rd-navbar-static" data-xxl-layout="rd-navbar-static" data-xxl-device-layout="rd-navbar-static" data-lg-stick-up-offset="46px" data-xl-stick-up-offset="46px" data-xxl-stick-up-offset="46px" data-lg-stick-up="true" data-xl-stick-up="true" data-xxl-stick-up="true">
            <div class="rd-navbar-main-outer">
              <div class="rd-navbar-main">
                <div class="rd-navbar-panel">
                  <button class="rd-navbar-toggle" data-rd-navbar-toggle=".rd-navbar-nav-wrap"><span></span></button>
                  <div class="rd-navbar-brand"><a class="brand" href="https://utecan.edu.mx/" target="_blank"><img src="{{asset('assets/img/logo.png')}}" alt="" width="223" height="50"/></a></div>
                </div>
                <div class="rd-navbar-main-element">
                  <div class="rd-navbar-nav-wrap">
                    <ul class="rd-navbar-nav">
                      <li class="rd-nav-item active"><a class="rd-nav-link" href="#inicio">Utecan</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="{{ route('user.login') }}">Empresarial</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="{{route('facturas.index')}}">Estudiantes</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#ubicacion">Ubicacion</a></li>
                      <li class="rd-nav-item"><a class="rd-nav-link" href="#">Reportar</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </nav>
        </div>
      </header>
      
      <!-- Swiper-->
      <section class="section swiper-container swiper-slider swiper-slider-classic" data-loop="true" data-autoplay="4859" data-simulate-touch="true" data-direction="vertical" data-nav="false">
        <div class="swiper-wrapper text-center">
          <div class="swiper-slide" data-slide-bg="{{asset('assets/img/slider-1-slide-2-1770x742.jpg')}}">
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">Facturación Rapida</h1>
                <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">"Genera tus facturas de la manera más sencilla."</p>
              </div>
            </div>
          </div>
          <div class="swiper-slide" data-slide-bg="{{asset('assets/img/slider-1-slide-6-1770x742.jpg')}}">
            <div class="swiper-slide-caption section-md">
              <div class="container">
                <h1 data-caption-animate="fadeInLeft" data-caption-delay="0">Timbrado Rapido</h1>
                <p class="text-width-large" data-caption-animate="fadeInRight" data-caption-delay="100">"Timbrado ágil y eficiente para optimizar tu proceso de facturación."</p>
              </div>
            </div>
          </div>
        </div>
      </section>    
    </div>
    
    <!-- See all services-->
    <section class="section section-sm section-first bg-default text-center" id="servicio">
      <div class="container">
        <div class="row row-30 justify-content-center">
          <div class="col-md-7 col-lg-5 col-xl-6 text-lg-left wow fadeInUp"><img src="{{asset('assets/img/index-1-415x592.webp')}}" alt="" width="415" height="6"/>
          </div>
          <div class="col-lg-7 col-xl-6">
            <div class="row row-30">
              <div class="col-sm-6 wow fadeInRight">
                <article class="box-icon-modern box-icon-modern-custom">
                  <div>
                    <h3 class="box-icon-modern-big-title">Que ofrecemos?</h3>
                  </div>
                </article>
              </div>
              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".1s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon linearicons-phone-in-out"></div>
                  <h5 class="box-icon-modern-title"><a href="#">Facturas formales y<br> profesionales</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">¿Necesitas un software que facture para tu empresa? Estamos listos!</p>
                </article>
              </div>
              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".2s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon linearicons-headset"></div>
                  <h5 class="box-icon-modern-title"><a href="#">Opciones enfocadas en tecnología y<br>software</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Facturación electrónica con integración a plataformas contables y fiscales como Facturama</p>
                </article>
              </div>
              <div class="col-sm-6 wow fadeInRight" data-wow-delay=".3s">
                <article class="box-icon-modern box-icon-modern-2">
                  <div class="box-icon-modern-icon linearicons-outbox"></div>
                  <h5 class="box-icon-modern-title"><a href="#">Opciones dinámicas<br>modernas</a></h5>
                  <div class="box-icon-modern-decor"></div>
                  <p class="box-icon-modern-text">Ofrecemos soluciones dinamicas de facturacion rapida y simple</p>
                </article>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Years of experience-->
    <section class="section section-sm bg-default my-5">
      <div class="container">
        <div class="row row-30 row-xl-24 justify-content-center align-items-center align-items-lg-start text-left">
          <div class="col-md-6 col-lg-5 col-xl-4 text-center"><a class="text-img" href="#">
            <div id="particles-js"></div><span class="counter">10</span></a></div>
            <div class="col-sm-8 col-md-6 col-lg-5 col-xl-4">
              <div class="text-width-extra-small offset-top-lg-24 wow fadeInUp">
                <h3 class="title-decoration-lines-left">Veces mas simple y efectivo</h3>
                <p class="text-gray-500">Un sistema rapido y seguro integrado con plataformas populares del momento como facturama</p>
              </div>
            </div>
          </div>
        </section>
        <!-- Precio-->
        {{-- <section class="section section-sm section-bottom-70 section-fluid bg-default">
          <div class="container">
            <h2>Planes de Facturación (En Desarrollo "Beta")</h2>
            <div class="row row-30 justify-content-center">
              <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="box-pricing box-pricing-black">
                  <div class="box-pricing-body">
                    <h5 class="box-pricing-title">Básico</h5>
                    <h3 class="box-pricing-price">$300.00/mes</h3>
                    <div class="box-pricing-time">Incluye:</div>
                    <div class="box-pricing-divider">
                      <div class="divider"></div><span></span>
                    </div>
                    <ul class="box-pricing-list">
                      <li class="active">Emisión de hasta 50 facturas mensuales</li>
                      <li class="active">Soporte técnico básico</li>
                      <li>Reportes de facturación</li>
                      <li>Integración con contabilidad</li>
                      <li>Personalización de facturas</li>
                    </ul>
                  </div>
                  <div class="box-pricing-button"><a class="button button-lg button-block button-gray-4" href="#">Elegir Plan</a></div>
                </div>
              </div>
              <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="box-pricing box-pricing-black box-pricing-popular">
                  <div class="box-pricing-body">
                    <h5 class="box-pricing-title">Profesional</h5>
                    <h3 class="box-pricing-price">$600.00/mes</h3>
                    <div class="box-pricing-time">Incluye:</div>
                    <div class="box-pricing-divider">
                      <div class="divider"></div><span></span>
                    </div>
                    <ul class="box-pricing-list">
                      <li class="active">Emisión de hasta 200 facturas mensuales</li>
                      <li class="active">Soporte técnico prioritario</li>
                      <li class="active">Reportes avanzados de facturación</li>
                      <li class="active">Integración con sistemas contables</li>
                    </ul>
                  </div>
                  <div class="box-pricing-button"><a class="button button-lg button-block button-primary" href="#">Elegir Plan</a></div>
                  <div class="box-pricing-badge">Popular</div>
                </div>
              </div>
              <div class="col-md-6 col-lg-5 col-xl-4">
                <div class="box-pricing box-pricing-black">
                  <div class="box-pricing-body">
                    <h5 class="box-pricing-title">Empresarial</h5>
                    <h3 class="box-pricing-price">$1,200.00/mes</h3>
                    <div class="box-pricing-time">Incluye:</div>
                    <div class="box-pricing-divider">
                      <div class="divider"></div><span></span>
                    </div>
                    <ul class="box-pricing-list">
                      <li class="active">Facturación ilimitada</li>
                      <li class="active">Soporte técnico 24/7</li>
                      <li class="active">Reportes y análisis de facturación</li>
                      <li class="active">Integración con múltiples plataformas</li>
                      <li class="active">Automatización de procesos</li>
                    </ul>
                  </div>
                  <div class="box-pricing-button"><a class="button button-lg button-block button-gray-4" href="#">Elegir Plan</a></div>
                </div>
              </div>
            </div>
          </div>
        </section> --}}
        
        
        <section id="ubicacion" class="my-5">
          <div class="col-md-12">
            <div id="map" style="height: 700px;width: 100%;"></div>
          </div>
        </section>
      </div>
      
      <style>
        .box-pricing {
          display: flex;
          flex-direction: column;
          height: 100%;
        }
        .box-pricing-body {
          flex-grow: 1;
        }
      </style>
      
      <script src="{{asset('assets3/js/core.min.js')}}"></script>
      <script src="{{asset('assets3/js/script.js')}}"></script>
      <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
      <script>
        document.addEventListener('DOMContentLoaded', function () {
          let mensaje = document.getElementById('mensaje');
          if (mensaje) {
            setTimeout(function () {
              mensaje.style.opacity = 0;
              setTimeout(function () {
                mensaje.style.display = 'none';
              }, 600);
            }, 3000);
          }
          
          let mapContainer = document.getElementById('map');
          if (mapContainer) {
            var latitud = 18.2281887;
            var longitud = -91.0586279;
            
            var map = L.map('map', {
              scrollWheelZoom: false 
            }).setView([latitud, longitud], 7);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
            
            L.marker([latitud, longitud]).addTo(map)
            .bindPopup('Universidad Tecnologica de Candelaria')
            .openPopup();
          }
        });
        
      </script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script>
        @if(Session::has('mensajeError'))
        Swal.fire({
          position: 'center',
          icon: 'error',
          title: '{{ Session::get('mensajeError') }}',
          showConfirmButton: false,
          timer: 10000
        })
        @endif
      </script>
    </body>
    </html>
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    {{-- @extends('layouts.master')
    @section('contenido')
    <div class="container-fluid pt-3 pb-3 bg-success text-white">
      <div class="row align-items-center">
        <div class="col-6 d-flex align-items-center justify-content-center">
          <img src="{{ asset('images/Logo_128x50.svg') }}" alt="Logo" width="120px" height="35px">
        </div>
        <div class="col-6">
          <ul class="d-flex list-unstyled justify-content-center m-0 p-0">
            <li class="mx-3"><a href="#" class="text-white text-decoration-none">Utecan</a></li>
            <li class="mx-3"><a href="#" class="text-white text-decoration-none">Facturación Electrónica</a></li>
            <li class="mx-3"><a href="#" class="text-white text-decoration-none">SAT</a></li>
            <li class="mx-3"><a href="{{route('factura')}}" class="text-white text-decoration-none">Facturación</a></li>
          </ul>
        </div>
      </div>
    </div>
    
    <div class="container-md my-4">
      <div class="row">
        <div class="col-md-6 mb-4 mb-md-0">
          <img class="img-fluid rounded" src="{{ asset('images/Qué-es-la-declaración-de-depósitos-en-efectivo-del-SAT-1201x676-1926722080.png') }}" alt="Descripción de la imagen">
        </div>
        <div class="col-md-6 d-flex flex-column justify-content-center">
          <h4 class="mb-3">¿Qué es un sistema de facturación?</h4>
          <p>
            Un sistema de facturación simplifica y automatiza el proceso de generar facturas y gestionar la información relacionada con las ventas de productos o servicios de una empresa. Permite crear facturas de manera eficiente, incluyendo detalles como los datos del cliente, los productos o servicios vendidos, los precios y los impuestos aplicables.
          </p>
        </div>
      </div>
    </div>
    @endsection
    
    
    {{-- 
    <img src="{{asset('images/Logo_128x50.svg')}}" alt="" width="120px" height="35px">
    <h3>Facturacion electronica</h3> --}}
    {{-- <li><a href="{{route('factura')}}">Factura electronica</a></li> --}}
    
    {{-- <h1>
      Bienvenido al sistema de facturacion electronico Utecan
    </h1>
    <div class="slider">
      <img src="{{asset('images/Qué-es-la-declaración-de-depósitos-en-efectivo-del-SAT-1201x676-1926722080.png')}}" alt="">
      <h4>Que es un sistema de facturacion?</h4>
      <p>
        simplifica y automatiza el proceso de generar facturas y gestionar la información relacionada con las ventas de productos o servicios de una empresa. Permite crear facturas de manera eficiente, incluyendo detalles como los datos del cliente, los productos o servicios vendidos, los precios y los impuestos aplicables
      </p>
    </div> --}}