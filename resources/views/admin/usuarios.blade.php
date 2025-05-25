@php
$user = Auth::user();
@endphp
@extends('components.master')
@section('content')
<div class="container-fluid">
    <h4 class="mt-5 mb-4">Administradores</h4>
    @if ($usuarios->where('rol', 'admin')->isEmpty())
        <div class="alert alert-info text-center" role="alert">
            <i class="fas fa-user-shield"></i> No hay administradores registrados en el sistema.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">Rol</th>
                        <th class="text-center">Última Actualización</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios->where('rol', 'admin') as $admin)
                    <tr>
                        <td class="text-center">{{ $admin->id }}</td>
                        <td class="text-center">{{ $admin->email }}</td>
                        <td class="text-center"><b>{{ $admin->rol }}</b></td>
                        <td class="text-center">{{ $admin->updated_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
<div class="container-fluid mt-5">
    <h4 class="mb-4 mt-5">Lista de usuarios activos en el sistema</h4>
    @if ($usuarios->where('rol', '!=', 'admin')->isEmpty())
        <div class="alert alert-warning text-center" role="alert">
            <i class="fas fa-exclamation-circle"></i> No hay usuarios registrados en el sistema.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Nombre Usuario</th>
                        <th class="text-center">Correo</th>
                        <th class="text-center">RFC</th>
                        <th class="text-center">Rol del Usuario</th>
                        <th class="text-center">Última Actualización</th>
                        <th class="text-center">Usuario Facturama asignado</th>
                        <th class="text-center">Contraseña Facturama asignado</th>
                        <th class="text-center">Asignar cuenta Facturama</th>
                        <th class="text-center">Eliminar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios->where('rol', '!=', 'admin') as $usuario)
                    <tr>
                        <td class="text-center">{{ $usuario->id }}</td>
                        <td class="text-center">{{ $usuario->nombre_usuario }}</td>
                        <td class="text-center">{{ $usuario->email }}</td>
                        <td class="text-center">{{ $usuario->rfc }}</td>
                        <td class="text-center">{{ $usuario->rol }}</td>
                        <td class="text-center">{{ $usuario->updated_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">{{ $usuario->usuarioFacturama }}</td>
                        <td class="text-center">{{ $usuario->passwordFacturama }}</td>
                        <td class="text-center">
                            <button type="button" 
                                    class="btn btn-success btn-sm" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#assignModal"
                                    data-id="{{ $usuario->id }}">
                                Asignar
                            </button>
                        </td> 
                        <td class="text-center">
                            <form action="{{ route('delete.usuario', $usuario->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                            </form>
                        </td>                       
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>   
<!-- Modal -->
<div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="assignModalLabel">Asignar Cuenta de Facturama</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="assignForm" action="{{ route('usuario.facturama', ':id') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="factura_usuario" class="form-label">Usuario de Facturama</label>
                        <input type="text" class="form-control" id="usuarioFacturama" name="usuarioFacturama" placeholder="Usuario de Facturama">
                    </div>
                    <div class="mb-3">
                        <label for="factura_password" class="form-label">Contraseña de Facturama</label>
                        <input type="text" class="form-control" id="passwordFacturama" name="passwordFacturama" placeholder="Contraseña de Facturama">
                    </div>
                    <button type="submit" class="btn btn-primary">Asignar Cuenta</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('assignModal').addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var userId = button.getAttribute('data-id'); 
    var form = this.querySelector('form');
    form.action = form.action.replace(':id', userId);
});

</script>
@endsection