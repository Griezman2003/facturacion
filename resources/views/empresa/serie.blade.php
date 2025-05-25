@php
$user = Auth::user();   
@endphp
@extends('components.master')
@section('content')
<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 text-center">
            <div class="p-4 bg-light rounded shadow">
                <h1 class="fw-bold text-dark">
                    <i class="fas fa-folder-open me-2"></i> Carga y Administra tus Series
                </h1>
                <p class="lead text-muted">
                    Las series te permiten organizar y diferenciar la numeración de tus documentos fiscales, 
                    asegurando un control eficiente en la emisión de facturas, recibos y otros comprobantes.
                </p>
                <p class="text-dark">
                    Puedes asignar nombres personalizados a cada serie y definir su rango de folios según tus necesidades. 
                    Esto facilita la gestión y evita conflictos en la numeración de tus documentos oficiales.
                </p>

                <div class="accordion mt-4 mb-5" id="accordionSeries">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-dark text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <h3 class="card-title mb-0">
                                    <i class="fas fa-layer-group me-2"></i> Carga tus Series
                                </h3>
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionSeries">
                            <div class="accordion-body">
                                <form action="{{route('serie.sucursal', $user)}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Selecciona la sucursal a la que cargaras la serie</label>
                                        <select class="form-select"  name="Id" required>
                                            @foreach ($serieSucursales as $serieSucursal)
                                            <option value="{{$serieSucursal['Id']}}">{{$serieSucursal['Name']}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombreSerie" class="form-label">Nombre</label>
                                        <input type="text" class="form-control" id="nombreSerie" name="nombreSerie" placeholder="Ejemplo: A" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="descripcionSerie" class="form-label">Descripción</label>
                                        <input type="text" class="form-control" id="descripcionSerie" name="descripcionSerie" placeholder="Ejemplo: Serie A">
                                    </div>
                                    <div class="mb-3">
                                        <label for="folioSerie" class="form-label">Folio</label>
                                        <input type="number" class="form-control" id="folioSerie" name="folioSerie" placeholder="Ejemplo: (1)-(1000)" required>
                                    </div>
                                    <div class="col-md-12 mt-4" style="display: flex; justify-content:end; align-items:center;">
                                        <button type="submit" class="btn btn-primary"><i class="fas fa-cloud-upload-alt me-2"></i>Cargar Serie</button>
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

<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 text-center">
            <div class="p-4 bg-light rounded shadow">
                <h1 class="fw-bold text-dark">
                    <i class="fas fa-folder-open me-2"></i> Series Activas por Sucursal
                </h1>
                <p class="lead text-muted">
                    Aquí podrás ver todas las series activas organizadas por sucursal. 
                    Gestiona tus series de manera eficiente y lleva un control claro de la numeración de tus documentos.
                </p>
                <p class="text-dark">
                    Puedes revisar las series por cada sucursal y verificar la información detallada de cada una, 
                    asegurando así una correcta organización.
                </p>

                @if(count($seriesPorSucursal) > 0)
                    <div class="table-responsive mt-4">
                        @foreach($seriesPorSucursal as $nombreSucursal => $series)
                        <h3 class="mt-4 text-center text-white bg-dark p-3 rounded shadow-lg">
                            <i class="fas fa-building me-2"></i> Sucursal: {{ $nombreSucursal }}
                        </h3>                    
                        <div class="card shadow-sm rounded-4 w-100 w-md-75 mx-auto mt-4">
                            <div class="card-body">
                                <div class="table-responsive rounded shadow mt-4 bg-white">
                                    <table class="table table-hover table-striped table-bordered align-middle">
                                        <thead class="bg-dark text-white">
                                            <tr>
                                                <th class="text-center p-3">Folio</th>
                                                <th class="text-center p-3">Nombre</th>
                                                <th class="text-center p-3">Descripción</th>
                                                <th class="text-center p-3">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($series as $serie)
                                                <tr>
                                                    <td class="text-center fw-bold">{{ $serie['Folio'] }}</td>
                                                    <td class="text-center">{{ $serie['Name'] }}</td>
                                                    <td class="text-center">{{ $serie['Description'] }}</td>
                                                    <td class="text-center">
                                                        <button class="btn btn-danger delete-btn" 
                                                            data-id="{{ $serie['SucursalId'] }}" 
                                                            data-name="{{ $serie['Name'] }}">
                                                            Eliminar
                                                        </button>
                                                    </td>
                                                    <form id="deleteForm" action="{{ route('serie.delete', ['user'=>$user->id]) }}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="sucursal_id" id="sucursal_id">
                                                        <input type="hidden" name="sucursal_name" id="sucursal_name">
                                                    </form>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach    
                    </div>
                @else
                    <div class="table-responsive mt-4">
                        <tr>
                            <td colspan="4" class="text-center">
                                <div class="alert alert-info d-flex align-items-center justify-content-center shadow-sm" role="alert">
                                    <i class="fas fa-info-circle fa-3x me-3 text-primary"></i>
                                    <div>
                                        <h5 class="fw-bold mb-1">¡Aún no has registrado sucursales!</h5>
                                        <p class="mb-0">Actualmente no tienes sucursales activas registradas. Por lo que no puedes agregar series.
                                            Carga tus sucursales para comenzar a gestionar las series.</p>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>


<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
    button.addEventListener('click', function() {
        let sucursalId = this.getAttribute('data-id');
        let sucursalName = this.getAttribute('data-name');

        document.getElementById('sucursal_id').value = sucursalId;
        document.getElementById('sucursal_name').value = sucursalName;

        document.getElementById('deleteForm').submit();
    });
});
</script>

<style>
    .accordion-button::after {
    filter: invert(1);
}
</style>
@endsection