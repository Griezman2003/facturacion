@extends('auth.master')

@section('contenido')

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-4 text-center rounded-4" style="max-width: 450px; width: 100%;">
        <div class="card-body">
            @if(session('verified') && session('email'))
                <div class="modal fade show" id="resetPasswordModal" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true" style="display: block;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content rounded-4 shadow-lg">
                            <div class="modal-header bg-success text-white">
                                <h5 class="modal-title fw-bold" id="resetPasswordModalLabel">
                                    <i class="fas fa-check-circle me-2"></i> Código Verificado
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-4">Ingrese una nueva contraseña</p>
                                <form action="{{ route('password.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="email" value="{{ session('email') }}">

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Nueva Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg shadow-sm @error('password') is-invalid @enderror" 
                                                   name="password" required minlength="8" placeholder="Mínimo 8 caracteres" id="password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Confirmar Contraseña</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg shadow-sm @error('password_confirmation') is-invalid @enderror" 
                                                   name="password_confirmation" required minlength="8" placeholder="Confirme la contraseña" id="confirm_password">
                                            <button class="btn btn-outline-secondary toggle-password" type="button">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-success w-100 fw-bold py-2">
                                        <i class="fas fa-lock me-2"></i>Actualizar Contraseña
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                <div class="mb-4">
                    <h3 class="text-primary fw-bold mb-3">Verificación de Código</h3>
                    <p class="text-muted">Ingrese el código de verificación enviado a su correo</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('password.verify.code') }}" method="POST">
    @csrf
    <input type="hidden" name="email" value="{{ session('email') }}">

    <div class="mb-4">
        <label class="form-label fw-bold">Código de Verificación</label>
        <input type="text" name="code" 
               class="form-control form-control-lg text-center shadow-sm @error('code') is-invalid @enderror" 
               required maxlength="5" placeholder="•••••" autocomplete="off">
        @error('code')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary w-100 fw-bold py-2">
        <i class="fas fa-check-circle me-2"></i>Verificar Código
    </button>
</form>

<div class="mt-3 text-center">
    <p class="text-muted">¿No recibiste el código?</p>
    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        <input type="hidden" name="email" value="{{ session('email') }}">
        <button type="submit" class="btn btn-link fw-bold">
            <i class="fas fa-redo-alt me-1"></i>Reenviar Código
        </button>
    </form>
</div>

            @endif

        </div>
    </div>
</div>

<script>
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function () {
            let input = this.previousElementSibling;
            if (input.type === "password") {
                input.type = "text";
                this.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                input.type = "password";
                this.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
    });
</script>

@endsection
