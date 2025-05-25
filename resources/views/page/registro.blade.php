@extends('auth.master')
@section('contenido')
<body>
    <div class="main-login">
        <div class="left-login">
            <h1>Realiza tu registro y<br>empieza a facturar</h1>
            <img src="{{asset('images/registro.svg')}}" class="left-login-image" alt="Animação">
        </div>
        <form method="POST" action="{{ route('user.register') }}">
            @csrf
        <div class="right-login">
            <div class="card-login">
                <h1>Registrate</h1>
                <div class="textfield">
                    <label for="nombre_usuario">Nombre Usuario</label>
                    <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Ingrese su Usuario"  value="{{ old('nombre_usuario') }}" required>
                    @error('nombre_usuario')
                    <div class="error text-white">{{ $message }}</div>
                    @enderror
                </div>
                    <div class="textfield">
                        <label for="Correo">Correo Electrónico</label>
                        <input type="email" name="email" placeholder="Ingrese su Correo Electronico"  value="{{ old('email') }}" required>
                        @error('email')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="textfield">
                        <label for="ConfirmarCorreo">Confirmar Correo</label>
                        <input type="email" id="ConfirmarCorreo" name="ConfirmarEmail" placeholder="Confirma el Correo Electronico"  value="{{ old('ConfirmarEmail') }}" required>
                        @error('ConfirmarEmail')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="textfield">
                        <label>Contraseña</label>
                        <input type="password" name="password" id="registroPassword" placeholder="Ingrese su Contraseña" value="{{ old('password') }}" required>
                        @error('password')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                        <div class="form-check mt-2">
                            <input type="checkbox" id="showPassword" class="form-check-input" onclick="togglePasswordVisibility()">
                            <label for="showPassword" class="form-check-label text-white">Mostrar contraseña</label>
                        </div>
                    </div>
                    {{-- <div class="textfield">
                        <div class="g-recaptcha" data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}"></div>
                        @error('g-recaptcha-response')
                        <div class="error text-white">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    <button class="btn-login" type="submit">Registrarse</button>
                </form>
                <div class="row">
                    <div class="col-md-12">
                        <a href="{{route('user.login')}}" class="btn btn-link text-white">Ya tienes cuenta?</a>
                    </div>
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
        width: 100vw;
        height: 100vh;
        background: #282a36;
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .left-login{
        width: 50vw;
        height: 100vh;
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