@php
    $user = Auth::user();

    $usuarioFacturama = $user->usuarioFacturama;
    $passwordFacturama = $user->passwordFacturama;

    $csdUrl = "https://apisandbox.facturama.mx/api-lite/csds";
    $branchOfficeUrl = "https://apisandbox.facturama.mx/BranchOffice";

    $responseCsd = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($csdUrl);
    $hasValidCSD = false;
    $csds = [];
    if ($responseCsd->successful()) {
        $csds = $responseCsd->json();
        $hasValidCSD = count($csds) > 0;
    }

    $responseSucursal = Http::withBasicAuth($usuarioFacturama, $passwordFacturama)->get($branchOfficeUrl);
    $hasSucursal = false;

    if ($responseSucursal->successful()) {
        $sucursales = $responseSucursal->json();
        $hasSucursal = count($sucursales) > 0; 
    }
@endphp

<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">UTECAN</div>
            <a class="nav-link" href="{{ Auth::check() && Auth::user()->rol == 'admin' ? route('admin') : route('dashboard.index', $user) }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Panel Principal
            </a>

            <!-- Solo visible para el administrador -->
            @if(Auth::check() && Auth::user()->rol == 'admin')
                <div class="sb-sidenav-menu-heading">Administrador</div>
                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseAdmin" aria-expanded="false" aria-controls="collapseAdmin">
                    <div class="sb-nav-link-icon"><i class="fas fa-wrench"></i></div>
                    Herramientas
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>                
                <div class="collapse" id="collapseAdmin" aria-labelledby="headingAdmin" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        <a class="nav-link" href="{{ route('usuarios') }}"><i class="fas fa-user" style="margin-right: 10px;"></i>Usuarios Activos</a>
                        <a class="nav-link" href="{{ route('facturas') }}"><i class="fas fa-file-invoice" style="margin-right: 10px;"></i>Facturas Emitidas</a>
                    </nav>
                </div>
            @endif

            <!-- Solo visible para el cliente-->
            @if(Auth::check() && Auth::user()->rol != 'admin')
                <div class="sb-sidenav-menu-heading">Opciones</div>
                <a class="nav-link collapsed" href="" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                    <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div>
                    Usuario
                    <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                </a>
                <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                    <nav class="sb-sidenav-menu-nested nav">
                        @if($hasValidCSD)
                            <a class="nav-link" href="{{ route('csd', $user) }}">
                                <i class="fas fa-file-signature" style="margin-right: 10px;"></i>CSD
                            </a>
                            <a class="nav-link" href="{{ route('sucursal.usuario', $user) }}">
                                <i class="fas fa-building" style="margin-right: 10px;"></i>SUCURSAL
                            </a>
                            <a class="nav-link {{ !$hasSucursal ? 'disabled' : '' }}" href="{{ route('serie', $user) }}" title="Necesitas agregar una sucursal para acceder a esta opción">
                                <i class="fas fa-building" style="margin-right: 10px;"></i>SERIE
                            </a>
                        @else
                            <a class="nav-link" href="{{ route('csd', $user)}}" title="CSD no válido o no cargado">
                                <i class="fas fa-file-signature" style="margin-right: 10px;"></i>CSD
                            </a>
                            <a class="nav-link disabled"  title="No puedes acceder a Sucursal sin CSD válido">
                                <i class="fas fa-building" style="margin-right: 10px;"></i>SUCURSAL
                            </a>
                            <a class="nav-link disabled"  title="No puedes acceder a Serie sin CSD válido">
                                <i class="fas fa-building" style="margin-right: 10px;"></i>SERIE
                            </a>
                        @endif
                    </nav>
                </div>

                <!-- Sección Facturar solo habilitada si tiene sucursal y serie activa -->
                @if($hasSucursal && $hasValidCSD)
                    <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapsePages">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                        Facturar
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapsePages" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav accordion" id="sidenavAccordionPages">
                            <a class="nav-link" href="{{ route('dashboard.factura', $user) }}">
                                <i class="fas fa-file-invoice-dollar" style="margin-right: 10px;"></i>Generar Factura
                            </a>
                        </nav>
                    </div>
                @else
                    <a class="nav-link disabled" href="#" title="Necesitas una sucursal y serie activa para generar facturas">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div>
                        Facturar
                    </a>
                @endif
            @endif
        </div>
    </div>
</nav>
