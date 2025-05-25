@php
$user = Auth::user();   
@endphp
@extends('components.master')
@section('content')
<div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 text-center">
            <div class="p-4 bg-light rounded shadow">
                <h1 class="fw-bold text-dark">
                    <i class="fas fa-store me-2"></i> Carga y Administra tus Sucursales
                </h1>
                <p class="lead text-muted">
                    Administra tus sucursales para mantener un control eficiente de las ubicaciones y operaciones de tu negocio.
                </p>
                
                <div class="accordion mt-4 mb-5" id="accordionSucursales">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-building me-2"></i> Carga tus Sucursales
                                </h3>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionSucursales">
                            <div class="accordion-body">
                                <form action="{{route('sucursal', $user)}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="nameSucursal" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nameSucursal" name="nameSucursal" placeholder="Ejemplo: El Sauce" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descriptionSucursal" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descriptionSucursal" name="descriptionSucursal" placeholder="Ejemplo: Sucursal del sauce, enfocada en la distribución de agua en garrafón">
                                    </div>
                                    <div class="mb-3">
                                        <label for="streetSucursal" class="form-label">Calle</label>
                                        <input type="text" class="form-control" id="streetSucursal" name="streetSucursal" placeholder="Ejemplo: Av. del Sauce" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="extNumberSucursal" class="form-label">Número Exterior</label>
                                        <input type="text" class="form-control" id="extNumberSucursal" name="extNumberSucursal" placeholder="Ejemplo: 120" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="intNumberSucursal" class="form-label">Número Interior</label>
                                        <input type="text" class="form-control" id="intNumberSucursal" name="intNumberSucursal" placeholder="Ejemplo: (dejar en blanco si no aplica)">
                                    </div>
                                    <div class="mb-3">
                                        <label for="neighborhoodSucursal" class="form-label">Colonia</label>
                                        <input type="text" class="form-control" id="neighborhoodSucursal" name="neighborhoodSucursal" placeholder="Ejemplo: Las Flores" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="zipCodeSucursal" class="form-label">Código Postal</label>
                                        <input type="text" class="form-control" id="zipCodeSucursal" name="zipCodeSucursal" placeholder="Ejemplo: 24330" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="municipalitySucursal" class="form-label">Municipio</label>
                                        <input type="text" class="form-control" id="municipalitySucursal" name="municipalitySucursal" placeholder="Ejemplo: San Luis Potosí" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="stateSucursal" class="form-label">Estado</label>
                                        <input type="text" class="form-control" id="stateSucursal" name="stateSucursal" placeholder="Ejemplo: San Luis Potosí" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="countrySucursal" class="form-label">País</label>
                                        <input type="text" class="form-control" id="countrySucursal" name="countrySucursal" placeholder="Ejemplo: México" required>
                                    </div>
                                    <div class="col-md-12 mt-4" style="display: flex; justify-content:end; align-items:center;">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-upload-alt me-2"></i>Cargar Sucursal</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 text-center">
            <div class="p-4 bg-light rounded shadow">
                <h1 class="fw-bold text-dark">
                    <i class="fas fa-store me-2"></i> Sucursales Activas
                </h1>
                <p class="lead text-muted">
                    Aquí puedes ver todas las sucursales activas asociadas a tu cuenta.
                </p>
                
                @if(count($sucursales) == 0)
                <table class="table table-striped mt-4">
                    <tr>
                        <td colspan="10" class="text-center">
                            <div class="alert alert-info d-flex align-items-center justify-content-center shadow-sm" role="alert">
                                <i class="fas fa-info-circle fa-3x me-3 text-primary"></i>
                                <div>
                                    <h5 class="fw-bold mb-1">¡Aún no has registrado sucursales!</h5>
                                    <p class="mb-0">No tienes sucursales activas registradas en este momento. ¡Agrega una nueva sucursal para comenzar!</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </table>
                @else
                <table class="table table-striped mt-4">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Dirección</th>
                            <th>Colonia</th>
                            <th>Código Postal</th>
                            <th>Municipio</th>
                            <th>Estado</th>
                            <th>País</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sucursales as $sucursal)
                        <tr>
                            <td>{{ $sucursal['Id'] ?? 'No disponible' }}</td>
                            <td>{{ $sucursal['Name'] ?? 'Sin nombre' }}</td>
                            <td>{{ $sucursal['Description'] ?? 'Sin descripción' }}</td>
                            <td>{{ $sucursal['Address']['Street'] ?? 'No disponible' }} {{ $sucursal['Address']['ExteriorNumber'] ?? '' }}</td>
                            <td>{{ $sucursal['Address']['Neighborhood'] ?? 'No disponible' }}</td>
                            <td>{{ $sucursal['Address']['ZipCode'] ?? 'No disponible' }}</td>
                            <td>{{ $sucursal['Address']['Municipality'] ?? 'No disponible' }}</td>
                            <td>{{ $sucursal['Address']['State'] ?? 'No disponible' }}</td>
                            <td>{{ $sucursal['Address']['Country'] ?? 'No disponible' }}</td>
                            <td>
                                <form action="{{ route('sucursal.delete', ['id' => $sucursal['Id'], 'user' => $user->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
    .accordion-button::after {
        filter: invert(1);
    }
</style>
@endsection