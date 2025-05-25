@extends('auth.master')
@section('contenido')
@php
$Indice = [
"I" =>"INGRESO",
"E" => "EGRESO",
"T" => "TRASLADO"
];
@endphp
<script src="{{ asset('js/obtenerFolio.js') }}"></script>

<div class="container-md bg-success d-flex align-items-center p-0 mt-2">
    <h3 class="text-white col-md-6 text-center m-0">Facturación electrónica</h3>
    <a class="col-md-6 text-decoration-none text-white fs-4 mx-auto d-flex justify-content-center align-items-center" href="/">Inicio</a>
</div>
<div class="h-auto mt-4">
    <div class="container-md">
        <form id="Factura" method="POST" action="{{ route('facturas.generate') }}">
            @csrf
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3">
                            <img 
                            class="img-fluid rounded shadow-sm" 
                            src="../images/factura.jpg" 
                            alt="Factura"
                            />
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="row">
                                    <div class="col-md-6 mb-2">
                                        <label for="serie2" class="form-label">Serie</label>
                                        <select class="form-select border-0 shadow-sm" id="serie2" name="serie2" required>
                                            <option value="" disabled selected>Seleccione una opción</option>
                                            @foreach (array_keys(Storage::exists('series.json') ? json_decode(Storage::get('series.json'), true) : ["A" => 0, "B" => 0, "C" => 0]) as $serie)
                                            <option value="{{ $serie }}">{{ $serie }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="folio2" class="form-label fw-bold">Folio</label>
                                        <input type="text" class="form-control border-0 shadow-sm" id="folio2" name="folio2" placeholder="Autogenerado" readonly>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Fecha de Emisión</label>
                                        <input type="datetime-local" id="fecha" name="fecha" class="form-control"  readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Tipo de Comprobante</label>
                                        <select name="comprobante" id="comprobante" class="form-select" required>
                                            @foreach ($Indice as $key => $indice)
                                            <option value="{{ $indice }}" {{ old('comprobante') == $indice ? 'selected' : '' }}>{{ $key }} - {{ $indice }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Datos del Emisor</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre/Razón Social</label>
                                <input type="text" name="emisor" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input type="text" name="rfc" class="form-control" maxlength="13" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="lugar_expedicion" class="form-label"><strong>Lugar de Expedición</strong></label>
                                <input type="text" class="form-control" id="lugar_expedicion" name="lugar_expedicion" placeholder="Ejemplo: 64000" required disabled>
                                <small id="ubicacion_error" class="text-danger" style="display: none;">
                                    <!-- Este contenido será reemplazado dinámicamente -->
                                </small>
                            </div>  --}}
                            <div class="mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="codigopostal"  class="form-control" required >
                                {{-- <small id="ubicacion_error" class="text-danger" style="display: none;">
                                    <!-- Este contenido será reemplazado dinámicamente -->
                                </small> --}}
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Régimen Fiscal</label>
                                <select name="regimenfiscal" class="form-select" required>
                                    @foreach($regimenFiscal as $json)
                                    <option value="{{ $json['id'] }}-{{ $json['descripcion'] }}">{{ $json['id'] }} - {{ $json['descripcion'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Método de Pago</label>
                                <select name="metodopago" class="form-select" required>
                                    @foreach($metodoPago as $metodo)
                                    <option value="{{ $metodo->id }}">{{ $metodo->id }} - {{ $metodo->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Condiciones</label>
                                <textarea name="condicion" class="form-control" rows="4" style="resize: none;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm h-100">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">Datos del Receptor</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Nombre/Razón Social</label>
                                <input type="text" name="receptor" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">RFC</label>
                                <input type="text" name="rfcReceptor" class="form-control" maxlength="13" required >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Código Postal</label>
                                <input type="text" name="codigopostalReceptor" class="form-control" required >
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Régimen Fiscal</label>
                                <select name="rfiscal" class="form-select" required>
                                    @foreach($regimenFiscal as $json)
                                    <option value="{{ $json['id'] }}-{{ $json['descripcion'] }}">{{ $json['id'] }} - {{ $json['descripcion'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Forma de Pago</label>
                                <select name="FormaPago" class="form-select" required>
                                    @foreach($formaPago as $forma)
                                    <option value="{{ $forma->id }}">{{ $forma->id }} - {{ $forma->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Uso de CFDI</label>
                                <select name="usocfdi" class="form-select" required>
                                    @foreach($usoCFDI as $uso)
                                    <option value="{{ $uso->id }}-{{ $uso->descripcion }}">{{ $uso->id }} - {{ $uso->descripcion }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            {{-- CREACION DEL MODAL --}}
            <div class="modal fade" id="Modal" tabindex="-1" aria-labelledby="ModalLabel"> 
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Registra tus productos</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="producto" class="form-label">Clave Producto/Servicio</label>
                                <select class="form-control chosen-select" id="producto" name="producto"> 
                                    @foreach($ProdServ as $producto)
                                    <option value="{{ $producto->id }}-{{ $producto->descripcion }}">
                                        {{ $producto->id }} {{ $producto->descripcion }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" id="cantidad" class="form-control" name="cantidad" required >
                            </div>
                            <div class="mb-3">
                                <label for="sat" class="form-label">Unidad SAT</label>
                                <select class="form-control chosen-select" id="sat" name="sat" required>
                                    @foreach($claveUnidad as $unidad)
                                    <option value="{{$unidad->id}}-{{$unidad->nombre}}">
                                        {{$unidad->id}} {{$unidad->nombre}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" name="descripcion"  required >
                            </div>
                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio Unitario</label>
                                <input type="number" class="form-control" id="precio" name="precio-unitario"  required>
                            </div>
                            <div class="mb-3">
                                <label for="tipoImpuesto" class="form-label">Tipo de Impuesto</label>
                                <select id="tipoImpuesto" class="form-control" name="tipo-impuesto">
                                    <option value="IVA">IVA</option>
                                    <option value="IEPS">IEPS</option>
                                    <option value="Exento">Exento</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tasa" class="form-label">Tasa (%)</label>
                                <input type="text" class="form-control" id="tasa" name="tasa"  placeholder="Porcentaje de impuesto" required >
                            </div>
                            <div class="mb-3">
                                <label for="impuesto" class="form-label">Impuesto Generado</label>
                                <input type="text" class="form-control" id="impuesto" name="impuesto-generado" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="importe" class="form-label">Importe</label>
                                <input type="text" class="form-control" id="importe" name="importe" readonly>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-success" id="agregarProducto">Agregar Producto</button>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Productos y Servicios</h5>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Clave</th>
                                    <th>Producto/Servicio</th>
                                    <th>Cantidad</th>
                                    <th>Unidad SAT</th>
                                    <th>Descripción</th>
                                    <th>Precio Unit.</th>
                                    <th>Tasa</th>
                                    <th>Impuesto</th>
                                    <th>Importe</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody">
                                <!-- Productos dinámicos -->
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer bg-white">
                    <div class="row justify-content-end">
                        <div class="col-md-8 mt-4">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#Modal">
                                <i class="bi bi-plus-lg me-2"></i> Agregar Producto
                            </button>
                        </div>
                        <div class="col-md-4">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <td class="text-end border-0">Subtotal:</td>
                                        <td class="text-end border-0" id="subtotal">$ 00.00</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end border-0">Impuestos:</td>
                                        <td class="text-end border-0" id="totalImpuesto">$ 00.00</td>
                                    </tr>
                                    <tr class="table-light fw-bold">
                                        <td class="text-end border-0">Total:</td>
                                        <td class="text-end border-0" id="totalFinal">$ 00.00</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-md py-2">
                <div class="row mt-1 mb-5">
                    <div class="col-md-12 d-flex justify-content-center">
                        <button type="submit" class="btn btn-success">Enviar Datos</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div> 
@endsection
