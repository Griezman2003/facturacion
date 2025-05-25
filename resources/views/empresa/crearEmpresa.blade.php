@extends('components.master')
@section('content')
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="text-center">Nueva Empresa</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{route('empresas.store')}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="nombreEmpresa" class="form-label">Nombre de la Empresa:</label>
                                <input type="text" class="form-control" name="nombreEmpresa" id="nombreEmpresa" placeholder="EXAMPLE UTECAN">
                            </div>
                            <h6 class="text-muted">Datos Generales de la Empresa</h6>
                            <div class="mb-3">
                                <label for="rfcEmpresa" class="form-label">RFC empresa:</label>
                                <input type="text" class="form-control" name="rfcEmpresa" id="rfcEmpresa" placeholder="INGRESE EL RFC">
                            </div>
                            <h6 class="text-muted">Catálogo de Cuentas</h6>
                            <div class="mb-3">
                                <label for="catalogoPreinstalado" class="form-label">Catálogo preinstalado:</label>
                                <select class="form-select" name="catalogoPreinstalado" id="catalogoPreinstalado">
                                    <option>Ninguno</option>
                                    <option>Opción 1</option>
                                    <option>Opción 2</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Estructura:</label>
                                <input type="text" name="estructura" class="form-control" placeholder="1-1-2-2">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Valores:</label>
                                <div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="valores" id="numericos" value="numericos" checked>
                                        <label class="form-check-label" for="numericos">Numéricos</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="valores" id="alfanumericos" value="alfanumericos">
                                        <label class="form-check-label" for="alfanumericos">Alfanuméricos</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Ubicación de la Empresa</h6>
                            <div class="mb-3">
                                <label for="servidorBDD" class="form-label">Servidor de BDD:</label>
                                <input type="text" class="form-control" name="servidorBDD" id="servidorBDD" value="localhost">
                            </div>
                            <div class="mb-3">
                                <label for="baseDatos" class="form-label">Base de Datos:</label>
                                <input type="text" class="form-control" name="baseDatos" id="baseDatos" placeholder="CtEmpresa1">
                            </div>
                            <h6 class="text-muted">Periodos Contables</h6>
                            <div class="mb-3">
                                <label for="tipoPeriodo" class="form-label">Tipo de Periodo:</label>
                                <select class="form-select" name="TipoPeriodo" id="tipoPeriodo">
                                    <option>Mensual</option>
                                    <option>Trimestral</option>
                                    <option>Anual</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="periodoEjercicio" class="form-label">Periodos del Ejercicio:</label>
                                <input type="number" name="PeriodosEjercicio" class="form-control" id="periodoEjercicio" value="12">
                            </div>
                            <div class="mb-3 form-check">
                                <input type="checkbox" name="periodosAbiertos" class="form-check-input" id="periodosAbiertos">
                                <label class="form-check-label" for="periodosAbiertos">Manejar Periodos Abiertos</label>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="button" class="btn btn-danger">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                icon: 'error',
                title: '¡Error en los campos!',
                html: `
                    <ul style="text-align: left; margin-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                confirmButtonText: 'Aceptar',
            });
        });
    </script>
    @endif
@endsection