@extends('auth.master')
@section('contenido')
@if (session('info'))
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header border-bottom-0 flex-column align-items-center pt-4 pb-2">
                    <div class="rounded-circle bg-light p-3 mb-2">
                        <i class="bi bi-info-circle text-primary fs-4"></i>
                    </div>
                    <h5 class="modal-title fw-semibold" id="infoModalLabel">⚠️ Advertencia</h5>
                </div>
                <div class="modal-body text-center px-4 py-4">
                    <p class="text-muted mb-0">{{ session('info') }}</p>
                </div>
                <div class="modal-footer border-top-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-primary px-4 py-2 rounded-3" data-bs-dismiss="modal">
                        Aceptar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
            infoModal.show();
        });
    </script>
@endif
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Factura<br>de la manera más eficiente</h1>
            <img src="{{asset('images/strategic-consulting-animate.svg')}}" class="left-login-image" alt="Animação">
        </div>
        <form method="POST" action="{{ route('user.authenticate') }}">
            @csrf
        <div class="right-login">
            <div class="card-login">
                <h1>LOGIN</h1>
                    <div class="textfield">
                        <label for="Correo">Usuario</label>
                        <input type="text" name="usuario" placeholder="Ingrese su Usuario"  value="{{ old('usuario') }}">
                        @error('usuario')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="textfield">
                        <label>Contraseña</label>
                        <input
                        type="password" 
                        name="password"
                        id="registroPassword"
                        placeholder="INGRESE SU CONTRASEÑA"
                        value="{{ old('password') }}">
                        @error('password')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                        <div class="form-check mt-2">
                            <input type="checkbox" id="showPassword" class="form-check-input" onclick="togglePasswordVisibility()">
                            <label for="showPassword" class="form-check-label text-white">Mostrar contraseña</label>
                        </div>
                    </div>
                    <button class="btn-login" type="submit">Ingresar al Sistema</button>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('user.registro')}}" class="btn btn-link text-white">Registrarse</a>
                        <button class="btn btn-link text-white" type="button" data-bs-toggle="modal" data-bs-target="#recuperarModal">
                            Recuperar Contraseña
                        </button> 
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <!-- Modal de Recuperación de Contraseña -->
    <div class="modal fade" id="recuperarModal" tabindex="-1" aria-labelledby="recuperarModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="recuperarModalLabel">
                        <i class="fas fa-key me-2"></i> Recuperar Contraseña
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted text-center mb-4">
                        Ingresa tu correo electrónico y te enviaremos un código para restablecer tu contraseña.
                    </p>
                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                name="email" placeholder="Ingrese su correo" required>
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Código
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>


<style>
    @import url('https://fonts.googleapis.com/css2?family=Noto+Sans:wght@400;700&display=swap');
    
    body {
        margin: 0;
        font-family: 'Noto Sans', sans-serif;
    }
    
    body * {
        box-sizing: border-box;
    }
    
    .main-login{
        width: 100dvw;
        height: 100vh;
        background: #282a36;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .left-login{
        width: 50vw;
        height: 100dvh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
    }
    
    .left-login > h1 {
        font-size: 3vw;
        color: #6ffc92;
    }
    
    .left-login-image{
        width: 35vw;
    }
    
    .right-login {
        width: 50vw;
        height: 100vh;
        padding-right: 0.4%;
        display: flex;
        justify-content: end;
        align-items: center;
    }
    
    .card-login {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 30px 35px ;
        background: #343746;
        box-shadow: 0px 10px 40px #191a21;
    }
    
    .card-login > h1 {
        color: #00ff88;
        font-weight: 800;
        margin: 0;
        margin-bottom: 20px;
    }
    
    .textfield {
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        justify-content: center;
        margin: 10px 0px;
    }
    
    .textfield > input {
        width: 100%;
        border: none;
        border-radius: 10px;
        padding: 15px;
        background: #424450;
        color: #f8f8f2;
        font-size: 12pt;
        box-shadow: 0px 10px 40px #191a21;
        outline: none;
        box-sizing: border-box;
    }


    .textfield > label {
        color: #f8f8f2;
        margin-bottom: 10px;
    }
    
    .textfield > input::placeholder {
        color: #f0ffff94;
    }
    
    .btn-login {
        width: 100%;
        padding: 16px 0px;
        margin: 25px;
        border: none;
        border-radius: 8px;
        outline: none;
        text-transform: uppercase;
        font-weight: 800;
        letter-spacing: 2px;
        color: #2b134b;
        background: #00ff88;
        cursor: pointer;
        box-shadow: 0px 10px 40px -12px #00ff8052;
    }
    
    
    @media only screen and (max-width: 950px){
        .card-login{
            width: 85%;
        }
    }
    
    @media only screen and (max-width: 600px){
        .main-login{
            flex-direction: column;
        }
        .left-login > h1 {
            display: none;
        }
        
        .left-login {
            width: 100%;
            height: auto;
        }
        .right-login {
            width: 100%;
            height: auto;
        }
        .left-login-image {
            width: 50vw;
        }
        .card-login {
            width: 90%;
        }
    }
</style>
@endsection



{{-- <body class="body">
    <div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg rounded-3">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="registroModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Registro de Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form method="POST" action="{{ route('user.register') }}">
                    @csrf
                    <div class="modal-body">
                        <p class="text-muted text-center mb-4">Regístrate con tu correo electrónico y una contraseña segura.</p>
                        
                        <div class="mb-3">
                            <label for="registroCorreo" class="form-label fw-medium">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                id="registroCorreo" name="email" placeholder="Ingrese su correo" required 
                                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" 
                                title="Ingrese un correo válido (ejemplo: usuario@dominio.com)">
                            </div>
                            @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="registroPassword" class="form-label fw-medium">Contraseña</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fas fa-lock"></i></span>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                id="registroPassword" name="password" placeholder="Ingrese su contraseña" required>
                            </div>
                            @error('password')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                            <div class="form-check mt-2">
                                <input type="checkbox" id="showPassword" class="form-check-input" onclick="togglePasswordVisibility()">
                                <label for="showPassword" class="form-check-label">Mostrar contraseña</label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary fw-bold">
                            <i class="fas fa-user-check me-2"></i> Registrarse
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="card-login">
        <div class="header-login">
            <div class="logo">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z"/>
                    <path d="M16 8h-6a2 2 0 1 0 0 4h4a2 2 0 1 1 0 4H8"/>
                    <path d="M12 17V7"/>
                </svg>
            </div>
            <h1 class="h1-login">Sistema de Facturación</h1>
            <p class="description">Ingrese sus credenciales para acceder al sistema</p>
        </div>
        <form method="POST" action="{{ route('user.authenticate') }}">
            @csrf
            <div class="form-group">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 2v20l2-1 2 1 2-1 2 1 2-1 2 1 2-1 2 1V2l-2 1-2-1-2 1-2-1-2 1-2-1-2 1-2-1Z"/>
                    </svg>
                    Correo Electronico
                </label>
                <input class="input-login" 
                type="email" 
                placeholder="Ingrese su Correo Electronico"
                name="email"
                pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                title="Ingrese un Correo válido"
                value="{{ old('email') }}"
                >
                @error('email')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="11" x="3" y="11" rx="2" ry="2"/>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                    </svg>
                    Contraseña
                </label>
                <input class="input-login"
                type="password" 
                name="password"
                placeholder="INGRESE SU CONTRASEÑA"
                value="{{ old('password') }}"
                >
                @error('password')
                <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <button class="button-Login" type="submit">Ingresar al Sistema</button>
        </form>
        <button class="btn-registrar" type="button" class="btn-registrar" data-bs-toggle="modal" data-bs-target="#registroModal">Registrarse</button>
        <button class="btn btn-link text-blue-600" type="button" data-bs-toggle="modal" data-bs-target="#recuperarModal">
            Recuperar Contraseña
        </button>
        <div class="modal fade" id="recuperarModal" tabindex="-1" aria-labelledby="recuperarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-3">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title fw-bold" id="recuperarModalLabel">
                            <i class="fas fa-key me-2"></i> Recuperar Contraseña
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-muted text-center mb-4">
                            Ingresa tu correo electrónico y te enviaremos un código para restablecer tu contraseña.
                        </p>
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Correo Electrónico</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                    name="email" placeholder="Ingrese su correo" required>
                                </div>
                                @error('email')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-center mt-4">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
                                    <i class="fas fa-paper-plane me-2"></i>Enviar Código
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body> --}}