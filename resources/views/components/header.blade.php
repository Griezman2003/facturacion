<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand ps-3" href="https://utecan.edu.mx/" target="_blank" rel="noopener noreferrer">UTECAN</a>
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                    {{-- <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
                    <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button> --}}
                </div>
            </form>
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        {{-- <li  id="eliminarPerfilBtn">
                            <a id="eliminarPerfilForm" class="dropdown-item text-danger" href="#">Eliminar perfil</a>
                        </li> --}}
                        @if(isset($user))
                        <li id="eliminaruserBtn" data-url="{{ route('user.eliminar', $user->id) }}">
                            <a class="dropdown-item text-danger" href="#">Eliminar cuenta</a>
                        </li>
                        @endif

                        <li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('salir').submit();">Salir</a>
                        </li>
                    </ul>
                </li>
            </ul>
            {{-- formulario oculto solo para cerrar sesion --}}
            <form id="salir" action="{{ route('user.logout') }}" method="POST" style="display: none;"> 
                @csrf
            </form>
        </nav>