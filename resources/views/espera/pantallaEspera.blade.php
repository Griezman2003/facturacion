@php
$user = Auth::user();  
@endphp

@extends('auth.master')
@section('contenido')
<div class="container text-center mt-5">
    <div class="alert alert-warning p-5" style="border-radius: 12px; background: #fff2e6; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);">
        <h2 class="mb-4 text-dark font-weight-bold"><i class="fas fa-exclamation-circle"></i> ¡Atención!</h2>
        <p class="lead mb-4 text-dark">Tu cuenta aún no ha sido asignada por un administrador. Por favor, contacta al soporte para completar el proceso.</p>
        <p class="text-muted mb-5">Una vez que se complete la asignación de tu cuenta, podrás acceder a todas las funcionalidades del sistema.</p>

        <div class="d-flex justify-content-center mb-4">
            <div class="spinner-border text-warning" role="status" style="width: 60px; height: 60px; animation: spin 1.5s linear infinite;">
                <span class="visually-hidden">Cargando...</span>
            </div>
        </div>
        <p class="text-muted">Estamos procesando tu solicitud</p>
    </div>
    <a href="{{ route('user.login') }}" class="btn btn-primary btn-lg mt-4 px-5" style="border-radius: 30px; padding: 12px 30px; font-weight: bold;">
        <i class="fas fa-arrow-left"></i> Volver a intentar
    </a>
</div>
<script>
    function checkAccountStatus() {
        fetch("{{ route('estadoCuenta', ['user' => $user->id]) }}")
            .then(response => response.json())
            .then(data => {
                if (data.assigned) {
                    window.location.href = "{{ route('dashboard.index', $user) }}";
                }
            })
            .catch(error => console.error("Error al verificar el estado de la cuenta:", error));
    }
    setInterval(() => {
        location.reload();
    }, 10000);

    checkAccountStatus();
</script>

<style>
    body {
        background: linear-gradient(120deg, #f8f9fa 0%, #f1f3f5 100%);
        font-family: 'Roboto', sans-serif;
    }

    .alert {
        background-color: #f8f9fa;
        border-left: 5px solid #f0ad4e;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .alert h2 {
        font-size: 2rem;
    }

    .spinner-border {
        animation: spin 1.5s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .btn-primary {
        background-color: #007bff;
        border-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        border-color: #0056b3;
    }
</style>
@endsection
