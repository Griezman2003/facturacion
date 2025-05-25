@extends('auth.master')
@section('contenido')
@if (session('success'))
<div id="mensaje" class="text-center alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div id="formulario" class="col-md-6 col-lg-4" style="background-color: rgba(0, 0, 0, 0.7); border-radius: 15px; padding: 40px 30px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
            <div class="mb-4 text-center">
                <img class="img-fluid" src="{{asset('images/logo.png')}}" alt="Logo" style="max-width: 100px;">
            </div>
            <div class="mb-3 text-center">
                <h3 class="text-white text-shadow">Formulario de Reporte</h3>
                <p class="text-white">Por favor, ingrese los detalles del reporte.</p>
            </div>
            <form enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="correo" class="form-label text-white">Correo del Cliente</label>
                    <input type="email" id="correo" name="correo" class="form-control" required autofocus>
                </div>
                <div class="mb-3">
                    <label for="descripcion" class="form-label text-white">Descripción del Error</label>
                    <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="imagen" class="form-label text-white">Anexar una Imagen</label>
                    <input type="file" id="imagen" name="imagen" class="form-control" accept="image/*">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3 w-100">Enviar Reporte</button>
                </div>
            </form>
        </div>
        <div class="col-md-6 mt-4">
            <div id="map" style="height: 400px; width: 100%;"></div>
        </div>

    </div>
</div>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<style>

    @media(max-width: 992px){
        #formulario{
            margin-top: 20px;
        }
    }

    #formulario {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    #map {
        border-radius: 10px;
    }
</style>


<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>

    document.addEventListener('DOMContentLoaded', function() {
        var latitud = 18.2281887;
        var longitud = -91.0586279;
        var map = L.map('map').setView([latitud, longitud], 16);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {}).addTo(map);
        L.marker([latitud, longitud]).addTo(map)
        .bindPopup('Universidad Tecnologica de Candelaria')
        .openPopup();
    });
</script>

@endsection