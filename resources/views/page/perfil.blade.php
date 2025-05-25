<div class="container-fluid d-flex justify-content-center align-items-center pt-5 pb-5">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card shadow-sm rounded-4 w-100 w-md-75">
        <div class="card-header bg-info text-white rounded-top-4">
            <h3 class="card-title mb-0">
                <i class="fas fa-user-cog me-2"></i> Carga tus datos fiscales
            </h3>
        </div>
        <div class="card-body">
            <form action=" {{route('profile.guardar')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tipoPersona" class="form-label">Tipo de persona <i class="fas fa-user"></i></label>
                        <select class="form-select rounded-3 shadow-sm" name="tipo_persona" required>
                            <option value="moral">Moral</option>
                            <option value="fisica">Física</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nombreFiscal" class="form-label">Nombre fiscal <i class="fas fa-id-card"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="nombreFiscal" name="nombre_fiscal" placeholder="Nombre Completo" value="Jesus Balan" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">E-mail <i class="fas fa-envelope"></i></label>
                        <input type="email" class="form-control rounded-3 shadow-sm" id="email" name="email" placeholder="Ingrese su Correo Electrónico" value="jesusvb@gmail.com" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">Teléfono <i class="fas fa-phone-alt"></i></label>
                        <input type="tel" class="form-control rounded-3 shadow-sm" id="telefono" name="telefono" value="9821088683">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tamanoEmpresa" class="form-label">Tamaño de la empresa <i class="fas fa-building"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="tamanoEmpresa" name="tamano_empresa" required>
                            <option value="micro">Micro (1-10 empleados)</option>
                            <option value="pequena">Pequeña (11-50 empleados)</option>
                            <option value="mediana">Mediana (51-250 empleados)</option>
                            <option value="grande">Grande (más de 250 empleados)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="regimenFiscal" class="form-label">Régimen fiscal <i class="fas fa-cogs"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="regimenFiscal" name="regimen_fiscal" required>
                            @foreach($regimenFiscal as $json)
                            <option value="{{ $json['id'] }}">
                                {{ $json['id'] }} {{ $json['descripcion'] }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ocupacion" class="form-label">Giro u ocupación <i class="fas fa-briefcase"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="ocupacion" name="ocupacion" placeholder="Ejemplo: Contador" value="Emprendedor" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nombre_comercial" class="form-label">Nombre Comercial <i class="fas fa-store"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="nombre_comercial" name="nombre_comercial" placeholder="Ejemplo: UNIVERSIDAD TECNOLOGICA DE CANDELARIA" value="utecan">
                    </div>
                </div>

                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="key_file" class="form-label"><strong>Llave Privada (.key) <i class="fas fa-key"></i></strong></label>
                        <input type="file" class="form-control rounded-3 shadow-sm" id="key_file" name="key_file" accept=".key">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="cer_file" class="form-label"><strong>Certificado (.cer) <i class="fas fa-certificate"></i></strong></label>
                        <input type="file" class="form-control rounded-3 shadow-sm" id="cer_file" name="cer_file" accept=".cer">
                    </div>
                </div>

                <div class="col-md-6 mb-3">
                    <label for="key_password" class="form-label"><strong>Contraseña de la Llave <i class="fas fa-lock"></i></strong></label>
                    <input type="password" class="form-control rounded-3 shadow-sm" id="key_password" name="key_password" autocomplete="new-password" value="12345678a" required>
                </div> --}}

                {{-- <div class="col-md-6 mb-3">
                    <label for="rfc_emisor"><strong>RFC <i class="fas fa-id-badge"></i></strong></label>
                    <input type="text" id="rfcEmisor" name="rfc" class="form-control rounded-3 shadow-sm" placeholder="Ingrese su RFC" maxlength="13" value="CACX7605101P8" required>
                    <small id="tipoPersona" class="form-text text-muted"></small>
                </div>

                <h5 class="mt-4">Dirección</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="codigoPostal" class="form-label">Código Postal <i class="fas fa-map-pin"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="codigoPostal" name="codigo_postal" value="24330" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="calle" class="form-label">Calle <i class="fas fa-road"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="calle" name="calle" value="#37" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="numExterior" class="form-label">Número Exterior <i class="fas fa-door-open"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="numExterior" name="numero_exterior" value="S/N" />
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="numInterior" class="form-label">Número Interior <i class="fas fa-door-closed"></i></label>
                        <input type="text" class="form-control rounded-3 shadow-sm" id="numInterior" name="num_interior" value="S/N" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="pais" class="form-label">País <i class="fas fa-globe"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="pais" name="pais" required>
                            <option value="MEXICO">México</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="estado" class="form-label">Estado <i class="fas fa-city"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="estado" name="estado" required>
                            <option value="">Selecciona un estado</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="colonia" class="form-label">Colonia <i class="fas fa-house-damage"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="colonia" name="colonia" required>
                            <option value="">Selecciona una colonia</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="municipio" class="form-label">Municipio <i class="fas fa-building"></i></label>
                        <select class="form-select rounded-3 shadow-sm" id="municipio" name="municipio" required>
                            <option value="">Selecciona un municipio</option>
                        </select>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-end">
                    <button type="submit" class="btn btn-info rounded-3">
                        <i class="fas fa-save me-2"></i>Guardar
                    </button>
                    
                    <button type="button" class="btn btn-secondary rounded-3"
                        onclick="window.location.href='{{ auth()->user()->perfil ? route('dashboard.index') : route('user.login') }}'">
                        <i class="fas fa-arrow-left me-2"></i>Regresar
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


