@extends('auth.master')
@section('contenido')

<div class="container-md text-end pt-2">
    <a id="no-print" class="text-decoration-none text-white fs-5 m-auto bg-success rounded p-1" href="/">Inició</a>
</div>
<div class="container-md pt-4">
    <div class="row">
        <div class="col-4">
            <h2 class="bg-primary fs-4 text-start text-white d-inline px-1 ">Comprobante Fiscal Digital</h2>
            <h4 class="fs-4 bg-light">Folio Interno <span class="text-danger fs-4"> {{isset($dato['folioInterno']) ? ($dato['folioInterno']): 'No disponible' }}</span></h4>
            <p class="bg-light">Folio Fiscal: <span class="text-danger">1231231231321</span></p>
        </div>
        
        <div class="col-4">
            <ul class="list-unstyled text-center">
                <li class=" custom-bg grosorLetra d-flex flex-column mb-1  text-black ">CSD del Emisor <span class="text-secondary bg-white">244343</span></li>
                <li class="custom-bg grosorLetra d-flex flex-column mb-1   text-black">Fecha de Emision <span class="text-secondary bg-white">{{isset($dato['fecha']) ? ($dato['fecha']): 'No disponible' }}</span></li>
                <li class="custom-bg grosorLetra d-flex flex-column mb-1   text-black">Tipo de Comprobante <span class="text-secondary bg-white">{{isset($dato['comprobante']) ? ($dato['comprobante']): 'No disponible' }}</span></li>
            </ul>
        </div>
        
        <div class="col-4">
            <ul class="list-unstyled text-center">
                <li class=" custom-bg grosorLetra d-flex flex-column mb-1   text-black">CSD del Sat  <span class="text-secondary bg-white">{{$sat}}</span></li>
                <li class="custom-bg grosorLetra d-flex flex-column mb-1  text-black">Fecha de certificacion  <span class="text-secondary bg-white">
                    @if(isset($dato['fecha']))
                    {{ $dato['fecha']}}
                    @else
                    No disponible
                    @endif 
                </span></li>
                <li class="custom-bg grosorLetra d-flex flex-column mb-1   text-black">Expedido en <span class="text-secondary bg-white">24330</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="container-md">
    <hr class="hr m-0">
</div>

<div class="container-md mt-2">
    <div class="row">
        <div class="col-6">
            <ul class="list-unstyled text-start">
                <li class="mb-2 grosorLetra fs-5">Datos del Emisor: <span class="ms-1"></span> <span class="  bg-white">{{isset($dato['emisor']) ? ($dato['emisor']): 'No disponible' }}</span></li>
                <li class="mb-2">Fecha de Emision: <span class="ms-1"></span><span class="text-secondary">
                    @if(isset(($dato['fecha'])))
                    {{$dato['fecha']}}
                    @else
                    No disponible
                    @endif    
                </span></li>
                
                <li class="mb-2">Régimen Fiscal:<span class="ms-1"></span> <span class="text-secondary bg-white">{{ isset($dato['regimenfiscal']) ? ($dato['regimenfiscal']): 'No disponible' }}</span></li>
                <li class="mb-2">Codigo Postal:<span class="ms-1"></span> <span class="text-secondary bg-white">{{ isset($dato['codigopostal']) ? ($dato['codigopostal']): 'No disponible' }}</span></li>
            </ul>
        </div>
        <div class="col-6">
            <ul class="list-unstyled text-start">
                <li class="mb-2 fs-5 text-black grosorLetra">Datos del Receptor: <span class="ms-1"></span> <span class=" bg-white">{{isset($dato['receptor']) ? ($dato['receptor']): 'No disponible' }}</span></li>
                <li class="mb-2">Domicilio fiscal: <span class="ms-1"></span> <span class=" text-secondary bg-white">{{isset($dato['codigopostalReceptor']) ? ($dato['codigopostalReceptor']): 'No disponible' }}</span></li>
                <li class="mb-2">Régimen Fiscal: <span class="ms-1"></span> <span class="text-secondary bg-white">{{isset($dato['rfiscal']) ? ($dato['rfiscal']): 'No disponible' }}</span></li>
                <li class="mb-2">Uso CFDI: <span class="ms-1"></span> <span class="text-secondary bg-white">{{isset($dato['usocfdi']) ? ($dato['usocfdi']): 'No disponible' }}</span></li>
            </ul>
        </div>
    </div>
</div>

<div class="container-md mt-5">
    <table class="table table-striped table-bordered text-center">
        <thead class="thead-dark">
            <tr>
                <th>Clave</th>
                <th>Producto/Servicio</th>
                <th>Cantidad</th>
                <th>Unidad SAT</th>
                <th>Descripcion</th>
                <th>Precio Unitario</th>
                <th> tasa</th>
                <th>Impuesto generado</th>
                <th>Importe</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            
        </tbody>
    </table>
</div>


<div class="container-md mt-5">
    <div class="row">
        <div class="col-4"></div>
        <div class="col-4">
            <ul class="list-unstyled text-end">
                <li>Subtotal:</li>
                <li>Total Impuestos Traslados:</li>
                <li>Total</li>
            </ul>
        </div>
        <div class="col-4">
            <ul class="list-unstyled text-end">
                <li id="subtotal">$ 00.00</li>
                <li id="totalImpuesto">$ 00.00</li> 
                <li id="totalFinal">$00.00</li>
            </ul>
        </div>
    </div>
    
</div>

<div class="container-md">
    <hr class="hr">
</div>

<div class="container-md mt-3">
    <div class="row">
        <div class="col-3 p-0 pt-3">
            <div>
                {!! QrCode::size(150)->generate($cadenaEmisor.$cadenaSAT.$cadenaTimbre) !!}
            </div>
        </div>
        <div class="col-9">
            <div class="column">
                <div>
                    <ul class="list-unstyled">
                        <li class="fw-bold text-wrap">Cadena Original del Timbre <span class="text-break fw-normal">{{$cadenaSAT}}</span>
                        </li>
                        
                        <li class="mt-3 fw-bold text-wrap">Sello Digital del Emisor <span class="text-break fw-normal">{{$cadenaEmisor}}</span>
                        </li>
                        
                        <li class="mt-3 fw-bold text-wrap">Sello Digital del SAT<br><span class="text-break fw-normal">{{$cadenaTimbre}}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid d-flex justify-content-center align-items-center mt-5 mb-5">
    <button id="no-print" class="text-white btn bg-primary" onclick="window.print()">Descarga</button>
</div>

<div class="container-md">
    <div class="col-4">
        <h5 id="no-print" class=" bg-success text-white  text-center d-inline px-2" >ING.Desarrollo Y Gestión de Software</h5>
    </div>
</div>
@endsection
<script>
    document.addEventListener("DOMContentLoaded", function() {
        function loadReciboData() {
            var totalImpuesto = localStorage.getItem('totalImpuesto') || '0.00';
            var subtotal = localStorage.getItem('subtotal') || '0.00';
            var totalFinal = localStorage.getItem('totalFinal') || '0.00';
            
            document.getElementById('totalImpuesto').textContent = `$ ${totalImpuesto}`;
            document.getElementById('subtotal').textContent = `$ ${subtotal}`;
            document.getElementById('totalFinal').textContent = `$ ${totalFinal}`;
        }
    
        function loadTableData() {
            var tableBody = document.getElementById('tableBody');
            var productos = JSON.parse(localStorage.getItem('productos')) || [];
            tableBody.innerHTML = '';
    
            productos.forEach(function(producto) {
                var newRow = tableBody.insertRow();
                newRow.insertCell().textContent = producto.clave || 'No disponible';
                newRow.insertCell().textContent = producto.producto || 'No disponible';
                newRow.insertCell().textContent = producto.cantidad || 'No disponible';
                newRow.insertCell().textContent = producto.sat || 'No disponible';
                newRow.insertCell().textContent = producto.descripcion || 'No disponible';
                newRow.insertCell().textContent = producto.precio || 'No disponible';
                newRow.insertCell().textContent = producto.tasa || 'No disponible';
                newRow.insertCell().textContent = producto.impuesto || 'No disponible';
                newRow.insertCell().textContent = producto.importe || 'No disponible';
            });
        }
    
        loadTableData();
        loadReciboData();
    });
    
    
</script>

































