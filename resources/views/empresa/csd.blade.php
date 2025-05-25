@php
$user =Auth::user();   
@endphp
@extends('components.master')
@section('content')
<div class="container-fluid d-flex justify-content-center align-items-center pt-5 pb-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-12 text-center">
                <div class="p-4 bg-light rounded shadow">
                    <h1 class="fw-bold text-dark">
                        <i class="fas fa-user-cog me-2"></i> Carga y Administra tus CSD
                    </h1>
                    <p class="lead text-muted">
                        Los CSD son esenciales para la correcta emisión de documentos fiscales. Asegúrate de tenerlos actualizados para evitar inconvenientes.
                    </p>
                    <p class="text-dark">
                        Puedes cargar tu llave privada, certificado y configurar tu RFC para empezar a utilizar tus CSD en el sistema.
                    </p>
                    
                    <div class="card shadow-sm rounded-4 w-100 w-md-75 mx-auto mt-4">
                        <div class="card-header bg-dark text-white rounded-top-4">
                            <h3 class="card-title mb-0">
                                <i class="fas fa-user-cog me-2"></i>Carga tus CSD
                            </h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('csd.create', $user) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <!-- Llave Privada -->
                                    <div class="col-12 mb-3">
                                        <label for="key_file" class="form-label"><strong>Llave Privada (.key) <i class="fas fa-key"></i></strong></label>
                                        <input type="file" class="form-control rounded-3 shadow-sm" name="llave_privada" accept=".key" required>
                                    </div>
                                    
                                    <!-- Certificado -->
                                    <div class="col-12 mb-3">
                                        <label for="cer_file" class="form-label"><strong>Certificado (.cer) <i class="fas fa-certificate"></i></strong></label>
                                        <input type="file" name="key_certificado" class="form-control rounded-3 shadow-sm" accept=".cer" required>
                                    </div>
                                </div>
                                
                                <div class="row">
                                    <!-- Contraseña de la Llave -->
                                    <div class="col-md-6 mb-3">
                                        <label for="key_password" class="form-label"><strong>Contraseña de la Llave <i class="fas fa-lock"></i></strong></label>
                                        <input type="password" name="key_password" class="form-control rounded-3 shadow-sm" required>
                                    </div>
                                    
                                    <!-- RFC -->
                                    <div class="col-md-6 mb-3">
                                        <label for="rfcEmisor"><strong>RFC <i class="fas fa-id-badge"></i></strong></label>
                                        <input type="text" id="rfcEmisor" name="rfc" class="form-control rounded-3 shadow-sm text-uppercase" maxlength="13" required oninput="this.value = this.value.toUpperCase();">
                                        <small id="tipoPersona" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                
                                <div class="d-grid gap-2 d-md-flex justify-content-end mt-4">
                                    <button type="submit" class="btn btn-primary rounded-3">
                                        <i class="fas fa-cloud-upload-alt me-2"></i>Cargar CSD
                                    </button>
                                </div>
                                
                                @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 text-center">
            <div class="p-4 bg-light rounded shadow">
                <h2 class="fw-bold text-dark">
                    <i class="fas fa-file-alt me-2"></i> Registro de tus CSDs cargados
                </h2>
                <p class="lead text-muted">
                    Aquí podrás ver los Certificados de Sello Digital (CSD) que tienes registrados. 
                    Estos certificados son necesarios para emitir tus facturas electrónicas de forma válida ante el SAT. 
                    Si necesitas eliminar algún CSD, puedes hacerlo desde esta sección.
                </p>
                <div class="card shadow-sm rounded-4 w-100 w-md-75 mx-auto mt-4">
                    <div class="card-body">
                        <div class="table-responsive rounded shadow mt-4 bg-white">
                            <table class="table table-hover table-striped table-bordered align-middle">
                                <thead class="bg-dark text-white">
                                    <tr>
                                        <th class="text-center p-3">RFC</th>
                                        <th class="text-center p-3">Fecha de Vencimiento</th>
                                        <th class="text-center p-3">Última Actualización</th>
                                        <th class="text-center p-3">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(empty($csds))
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <div class="alert alert-info d-flex align-items-center justify-content-center shadow-sm" role="alert">
                                                <i class="fas fa-info-circle fa-3x me-3 text-primary"></i>
                                                <div>
                                                    <h5 class="fw-bold mb-1">¡Aún no has registrado CSDs!</h5>
                                                    <p class="mb-0">No tienes CSDs registrados en este momento. ¡Carga tus certificados para comenzar a emitir facturas electrónicas!</p>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @else
                                    @foreach($csds as $csd)
                                    <tr>
                                        <td class="text-center fw-bold text-nowrap">{{ $csd['Rfc'] ?? 'Agrega un CSD'}}</td>
                                        <td class="text-center text-danger">{{ $csd['CsdExpirationDate'] ?? 'Agrega un CSD' }}</td>
                                        <td class="text-center text-primary">{{ $csd['UploadDate'] ?? 'Agrega un CSD' }}</td>
                                        <td class="text-center">
                                            <form action="{{ route('csd.eliminar', ['rfc' => $csd['Rfc'], 'user'=> $user->id]) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm shadow-sm">
                                                    <i class="fas fa-trash-alt me-1"></i> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection