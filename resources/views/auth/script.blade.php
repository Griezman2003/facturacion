<script src="{{ asset('jquery/js/jquery-3.7.1.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="{{ asset('select2/js/select2.min.js') }}"></script>
<script src="{{ asset('sweetalert2/js/sweetalert2.min.js') }}"></script>
<script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('fontawesome/js/all.js')}}" crossorigin="anonymous"></script>
<script src="{{ asset('assets2/js/scripts.js')}}"></script>
<script src="{{ asset('assets2/demo/chart-area-demo.js')}}"></script>
<script src="{{ asset('assets2/demo/chart-bar-demo.js')}}"></script>
<script src="{{ asset('assets2/js/datatables-simple-demo.js')}}"></script>
<script src="{{ asset('datatables/js/simple-datatables.js')}}" crossorigin="anonymous"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


<script>
    @if(Session::has('mensajeError'))
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: '{{ Session::get('mensajeError') }}',
        showConfirmButton: false,
        timer: 10000
    })
    @endif

    @if(Session::has('mensajeAlerta'))
        Swal.fire({
            position: 'center',
            icon: 'warning',
            title: '{{Session::get('mensajeAlerta')}}',
            showConfirmButton: true,
            timer: 10000
        })
    @endif

    
    @if(Session::has('mensaje'))
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: '{{ Session::get('mensaje') }}',
        showConfirmButton: false,
        timer: 2000
    })
    @endif
</script>

<script>
    document.getElementById("eliminarPerfilBtn").addEventListener("click", function (event) {
        event.preventDefault();
        
        Swal.fire({
            title: "¿Estás seguro?",
            text: "Sin un perfil no podrá generar facturas",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#6c757d",
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href="{{route('profile.eliminar')}}"
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const eliminarBtn = document.getElementById("eliminaruserBtn");
        
        if (eliminarBtn) {
            eliminarBtn.addEventListener("click", function (event) {
                event.preventDefault();
                
                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Si elimina su cuenta perdera todos los registros creados y facturados en el sistema",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#6c757d",
                    confirmButtonText: "Sí, eliminar",
                    cancelButtonText: "Cancelar"
                }).then((result) => {
                    if (result.isConfirmed) {
                        const url = eliminarBtn.getAttribute("data-url");
                        window.location.href = url;
                    }
                });
            });
        }
    });
</script>
<script>
    // Función para establecer la fecha y hora actuales en formato ISO 8601 (con segundos)
    function setFechaActual() {
        const fechaActual = new Date();
        const año = fechaActual.getFullYear();
        const mes = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Mes (01-12)
        const dia = String(fechaActual.getDate()).padStart(2, '0'); // Día (01-31)
        const horas = String(fechaActual.getHours()).padStart(2, '0'); // Horas (00-23)
        const minutos = String(fechaActual.getMinutes()).padStart(2, '0'); // Minutos (00-59)
        const segundos = String(fechaActual.getSeconds()).padStart(2, '0'); // Segundos (00-59)

        // Formato ISO 8601 con segundos: YYYY-MM-DDTHH:MM:SS
        const fechaFormateada = `${año}-${mes}-${dia}T${horas}:${minutos}:${segundos}`;

        // Asignar la fecha y hora al campo datetime-local
        document.getElementById("fecha").value = fechaFormateada;
    }

    // Ejecutar la función cuando la página se haya cargado
    window.onload = setFechaActual;
</script>


<script>
    $(document).ready(function() {
        $('.chosen-select').chosen({
            no_results_text: 'No se encontraron resultados',
            width: '100%'
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        $(document).ready(function() {
            $('#productoSelect').select2({
                placeholder: "Buscar producto",
                allowClear: true
            });
        });
        
        $(document).ready(function() {
            $('#productoSelect2').select2({
                placeholder: 'Seleccione una unidad SAT',
                allowClear: true,
                width: 'resolve'
            });
        });
    })
    
    $(document).ready(function() {
        $('#select-buscador').chosen({
            no_results_text: 'No se encontraron resultados',
            width: '100%'
        });
    });
    
    $(document).ready(function() {
        $('#select-buscador2').chosen({
            no_results_text: 'No se encontraron resultados',
            width: '100%'
        });
    });
</script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        let cantidadElement = document.getElementById('cantidad');
        let precioElement = document.getElementById('precio');
        let tasaElement = document.getElementById('tasa');
        let impuestoElement = document.getElementById('impuesto');
        let importeElement = document.getElementById('importe');
        
        
        function calcular() {
            let cantidad = parseFloat(cantidadElement.value) || 0;
            let precio = parseFloat(precioElement.value) || 0;
            let tasa = parseFloat(tasaElement.value) || 0;
            let subTotal = cantidad * precio;
            let total = subTotal * tasa;
            
            let importe = precio * cantidad;
            let finalImporte = importe + total;
            
            impuestoElement.value = total.toFixed(2);
            importeElement.value = finalImporte.toFixed(2);
        }
        cantidadElement.addEventListener('input', calcular);
        precioElement.addEventListener('input', calcular);
        tasaElement.addEventListener('input', calcular);
        
        
        calcular(); 
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function saveTotalImporte() {
            var total = 0;
            var rows = document.querySelectorAll('#tableBody tr');
            
            rows.forEach(function(row) {
                var cells = row.querySelectorAll('td');
                var importe = parseFloat(cells[8].textContent.replace(/[^0-9.-]+/g, "")) || 0;
                total += importe;
            });
            
            localStorage.setItem('totalImporte', total.toFixed(2));
        }
        
        function saveTotalImpuesto() {
            var total = 0;
            var rows = document.querySelectorAll('#tableBody tr');
            
            rows.forEach(function(row) {
                var cells = row.querySelectorAll('td');
                var impuesto = parseFloat(cells[7].textContent.replace(/[^0-9.-]+/g, "")) || 0;
                total += impuesto;
            });
            
            localStorage.setItem('totalImpuesto', total.toFixed(2));
        }
        
        function calculateSubtotal() {
            var totalImporte = parseFloat(localStorage.getItem('totalImporte')) || 0;
            var totalImpuesto = parseFloat(localStorage.getItem('totalImpuesto')) || 0;
            var subtotal = (totalImporte - totalImpuesto).toFixed(2);
            localStorage.setItem('subtotal', subtotal);
            return subtotal;
        }
        
        function calculateTotalFinal() {
            var subtotal = parseFloat(localStorage.getItem('subtotal')) || 0;
            var totalImpuesto = parseFloat(localStorage.getItem('totalImpuesto')) || 0;
            var totalFinal = (subtotal + totalImpuesto).toFixed(2);
            
            localStorage.setItem('totalFinal', totalFinal);
            return totalFinal;
        }
        
        function mostrarTotalImpuesto() {
            var totalImpuesto = localStorage.getItem('totalImpuesto') || '0.00';
             var totalImpuestoElement = document.getElementById('totalImpuesto');
             if (totalImpuestoElement) {
                totalImpuestoElement.textContent = `$ ${totalImpuesto}`;
            }
        }

        
        function mostrarSubtotal() {
            var subtotal = calculateSubtotal();
            var subtotalElement = document.getElementById('subtotal');
            if (subtotalElement) {
                subtotalElement.textContent = `$ ${subtotal}`;
            }
        }
        
        function mostrarTotalFinal() {
            var totalFinal = calculateTotalFinal();
            var totalFinalElement = document.getElementById('totalFinal');
            if (totalFinalElement) {
                totalFinalElement.textContent = `$ ${totalFinal}`;
            }
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
                newRow.insertCell().textContent = producto.impuesto || '0'; 
                newRow.insertCell().textContent = producto.importe || '0'; 
            });
            
            saveTotalImporte(); 
            saveTotalImpuesto(); 
            mostrarTotalImpuesto(); 
            mostrarSubtotal();  
            mostrarTotalFinal();
        }
        
        function saveProduct() {
            var producto = document.getElementById('producto').value.split('-');
            var cantidad = document.getElementById('cantidad').value;
            var sat = document.getElementById('sat').value.split('-');
            var descripcion = document.getElementById('descripcion').value;
            var precio = document.getElementById('precio').value;
            var tasa = document.getElementById('tasa').value;
            var impuesto = document.getElementById('impuesto').value;
            var importe = document.getElementById('importe').value;
            
            var productos = JSON.parse(localStorage.getItem('productos')) || [];
            productos.push({
                clave: producto[0],
                producto: producto[1],
                cantidad: cantidad,
                sat: `${sat[0]} ${sat[1]}`,
                descripcion: descripcion,
                precio: precio,
                tasa: tasa,
                impuesto: impuesto,
                importe: importe
            });
            localStorage.setItem('productos', JSON.stringify(productos));
        }
        
        document.getElementById('agregarProducto').addEventListener('click', function() {
            saveProduct(); 
            loadTableData();
            var modal = bootstrap.Modal.getInstance(document.getElementById('Modal'));
            modal.hide();
        });
        
        loadTableData(); 
        mostrarTotalFinal();  
    });
    
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        localStorage.removeItem('productos');
    });
</script>

{{-- esto es para los campos de empresa de factura  --}}
<script>
    function emisorRFC() {
        const rfcEmisor = document.getElementById('rfcEmisor').value.toUpperCase(); // Obtener y convertir el RFC a mayúsculas importante
        const tipoPersona = document.getElementById('tipoPersona');
        
        const rfcFisica = /^[A-ZÑ&]{4}[0-9]{6}[A-Z0-9]{3}$/; // Persona Física
        const rfcMoral = /^[A-ZÑ&]{3}[0-9]{6}[A-Z0-9]{3}$/;  // Persona Moral
        
        if (rfcFisica.test(rfcEmisor)) {
            tipoPersona.textContent = "El RFC pertenece a una Persona Física.";
            tipoPersona.style.color = "green";
        } else if (rfcMoral.test(rfcEmisor)) {
            tipoPersona.textContent = "El RFC pertenece a una Persona Moral.";
            tipoPersona.style.color = "blue";
        } else {
            tipoPersona.textContent = "El RFC ingresado no es válido.";
            tipoPersona.style.color = "red";
        }
    }
</script>

<script>
    function receptorRFC() {
        const rfcReceptor = document.getElementById('rfcReceptor').value.toUpperCase(); // Obtener y convertir el RFC a mayúsculas importante
        const tipo = document.getElementById('tipo');
        
        const rfcFisica = /^[A-ZÑ&]{4}[0-9]{6}[A-Z0-9]{3}$/; 
        const rfcMoral = /^[A-ZÑ&]{3}[0-9]{6}[A-Z0-9]{3}$/;  
        
        if (rfcFisica.test(rfcReceptor)) {
            tipo.textContent = "El RFC pertenece a una Persona Física.";
            tipo.style.color = "green";
        } else if (rfcMoral.test(rfcReceptor)) {
            tipo.textContent = "El RFC pertenece a una Persona Moral.";
            tipo.style.color = "blue";
        } else {
            tipo.textContent = "El RFC ingresado no es válido.";
            tipo.style.color = "red";
        }
    }
</script>
{{-- -------------------------------------------------------------------------------------------------------------------------------------------------------------- --}}
<script>
    function togglePasswordVisibility() {
        const passwordField = document.getElementById('registroPassword');
        const showPassword = document.getElementById('showPassword');
        passwordField.type = showPassword.checked ? 'text' : 'password';
    }
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        function configurarFolioListener(serieSelector, folioSelector) {
            const serieElement = document.getElementById(serieSelector);
            const folioElement = document.getElementById(folioSelector);
            
            if (serieElement) {
                serieElement.addEventListener("change", function () {
                    let serieSeleccionada = this.value;
                    console.log("Serie seleccionada:", serieSeleccionada);
                    if (serieSeleccionada) {
                        fetch(`/json/obtener-folio?serie=${serieSeleccionada}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log("Respuesta del servidor:", data);
                            if (folioElement) {
                                folioElement.value = data.folio;
                            }
                        })
                        .catch(error => console.error("Error obteniendo el folio:", error));
                    }
                });
            }
        }
        
        // Inicializa la funcionalidad en diferentes apartados
        configurarFolioListener("serie", "folio");  // Para la vista actual
        configurarFolioListener("serie2", "folio2"); // Para otro formulario
    });
    
</script>

<script>
    const OPEN_CAGE_API_KEY = ''; 
    function obtenerUbicacion() {
        const ubicacionError = document.getElementById('ubicacion_error');
        
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
            async (position) => {
                const { latitude, longitude } = position.coords;
                
                try {
                    const response = await fetch(
                    `https://api.opencagedata.com/geocode/v1/json?q=${latitude}+${longitude}&key=${OPEN_CAGE_API_KEY}`
                    );
                    const data = await response.json();
                    
                    if (data.results && data.results.length > 0) {
                        const lugar = data.results[0].components.postcode || 'No disponible';
                        document.getElementById('lugar_expedicion').value = lugar;
                    } else {
                        ubicacionError.innerHTML = `
                                No se pudo obtener el código postal. 
                                <a href="https://support.google.com/chrome/answer/142065" target="_blank">Haga clic aquí para ver cómo habilitarlo</a>.`;
                        ubicacionError.style.display = 'block';
                    }
                } catch (error) {
                    ubicacionError.innerText = 'Error al obtener la ubicación.';
                    ubicacionError.style.display = 'block'; // Mostrar mensaje
                    console.error('Error al llamar a la API:', error);
                }
            },
            (error) => {
                let mensajeError = '';
                switch (error.code) {
                    case error.PERMISSION_DENIED:
                    mensajeError = 'El permiso para acceder a la ubicación fue denegado. Por favor, habilítelo en la configuración de su navegador.';
                    break;
                    case error.POSITION_UNAVAILABLE:
                    mensajeError = 'La información de ubicación no está disponible.';
                    break;
                    case error.TIMEOUT:
                    mensajeError = 'La solicitud de geolocalización tardó demasiado.';
                    break;
                    default:
                    mensajeError = 'Ocurrió un error desconocido al intentar obtener la ubicación.';
                    break;
                }
                ubicacionError.innerText = mensajeError;
                ubicacionError.style.display = 'block'; 
                console.error('Error de geolocalización:', mensajeError);
            },
            {
                enableHighAccuracy: true,
                timeout: 10000,
                maximumAge: 0,
            }
            );
        } else {
            ubicacionError.innerText = 'La geolocalización no está soportada por este navegador.';
            ubicacionError.style.display = 'block'; 
        }
    }
    document.addEventListener('DOMContentLoaded', obtenerUbicacion);
</script>



<script>
    document.getElementById('serie').addEventListener('change', function() {
        const selectedSerie = this.value;
        const series = @json(json_decode(Storage::get('series.json'), true));
        const nextFolio = series[selectedSerie] + 1;
        
        document.getElementById('folio').value = nextFolio;
    });
    document.querySelectorAll('#modalNuevoProducto input, #modalNuevoProducto select').forEach(input => {
        input.addEventListener('input', calcularPrecioFinal);
    });
    
    
    const isrTabla = [
    { limiteInferior: 0.01, limiteSuperior: 7735.00, cuotaFija: 0.00, porcentaje: 1.92 },
    { limiteInferior: 7735.01, limiteSuperior: 65651.07, cuotaFija: 148.38, porcentaje: 6.40 },
    { limiteInferior: 65651.08, limiteSuperior: 115375.90, cuotaFija: 3459.42, porcentaje: 10.88 },
    { limiteInferior: 115375.91, limiteSuperior: 134119.41, cuotaFija: 8132.08, porcentaje: 16.00 },
    { limiteInferior: 134119.42, limiteSuperior: 160577.65, cuotaFija: 11940.83, porcentaje: 17.92 },
    { limiteInferior: 160577.66, limiteSuperior: 323862.00, cuotaFija: 17834.22, porcentaje: 21.36 },
    { limiteInferior: 323862.01, limiteSuperior: 510451.00, cuotaFija: 57366.74, porcentaje: 23.52 },
    { limiteInferior: 510451.01, limiteSuperior: 1027360.00, cuotaFija: 106277.16, porcentaje: 30.00 },
    { limiteInferior: 1027360.01, limiteSuperior: Infinity, cuotaFija: 253007.24, porcentaje: 35.00 },
    ];
    
    function calcularISRProgresivo(ingreso) {
        let isr = 0;
        for (let rango of isrTabla) {
            if (ingreso >= rango.limiteInferior && ingreso <= rango.limiteSuperior) {
                const excedente = ingreso - rango.limiteInferior;
                isr = rango.cuotaFija + (excedente * rango.porcentaje) / 100;
                break;
            }
        }
        return parseFloat(isr.toFixed(2));
    }
    
    // Función principal para calcular el precio final
    function calcularPrecioFinal() {
        const valorUnitario = parseFloat(document.getElementById("valorUnitario").value) || 0;
        const cantidad = parseInt(document.getElementById("cantidad").value) || 1;
        const iva = parseFloat(document.getElementById("iva").value) || 0;
        const ivaRetenido = parseFloat(document.getElementById("ivaRetenido").value) || 0;
        const isrOption = document.getElementById("isr").value;
        const ieps = parseFloat(document.getElementById("ieps").value) || 0;
        
        const importe = valorUnitario * cantidad;
        const montoIVA = (importe * iva);
        const montoIvaRetenido = (importe * ivaRetenido);
        const montoIEPS = (importe * ieps);
        
        let montoISR = 0;
        
        if (isrOption === "tablas") {
            montoISR = calcularISRProgresivo(importe);
        } else if (!isNaN(parseFloat(isrOption))) {
            const porcentajeISR = parseFloat(isrOption);
            montoISR = (importe * porcentajeISR);
        }
        
        const precioFinal = importe - montoISR + montoIVA - montoIvaRetenido + montoIEPS;
        
        document.getElementById("precioFinal").value = `$ ${precioFinal.toFixed(2)}`;
    }
    
    function actualizarCampoOculto() {
        const tbody = document.getElementById("conceptos-body");
        const productos = [];
        
        tbody.querySelectorAll("tr").forEach(row => {
            const columns = row.querySelectorAll("td");
            productos.push({
                claveProductoServicio: columns[0].textContent,
                descripcion: columns[1].textContent,
                cantidad: parseInt(columns[2].textContent),
                claveUnidad: columns[3].textContent,
                valorUnitario: parseFloat(columns[4].textContent),
                descuento: parseFloat(columns[5].textContent),
                importe: parseFloat(columns[6].textContent),
                nombreInterno: columns[7].textContent,
                noIdentificacion: columns[8].textContent,
                objetoImpuesto: columns[9].textContent,
                isr: parseFloat(columns[10].textContent) || 0,
                ivaRetenido: parseFloat(columns[11].textContent) || 0,
                ieps: parseFloat(columns[12].textContent) || 0,
                precioFinal: parseFloat(columns[13].textContent),
            });
        });
        
        document.getElementById("productos-json").value = JSON.stringify(productos);
    } 
    // Guardar producto y actualizar tabla
    function guardarProducto() {
        const claveProductoServicio = document.getElementById("buscadorProv").value.split("-")[0];
        const descripcion = document.getElementById("descripcion").value.trim();
        const cantidad = parseInt(document.getElementById("cantidad").value) || 1;
        const claveUnidad = document.getElementById("buscadorProv2").value;
        const valorUnitario = parseFloat(document.getElementById("valorUnitario").value) || 0;
        const nombreInterno = document.getElementById("nombreInterno").value.trim();
        const noIdentificacion = document.getElementById("noIdentificacion").value.trim();
        const objetoImpuesto = document.getElementById("objetoImpuesto").value;
        const iva = parseFloat(document.getElementById("iva").value) || 0;
        const isr = parseFloat(document.getElementById("isr").value) || 0;
        const ivaRetenido = parseFloat(document.getElementById("ivaRetenido").value) || 0;
        const ieps = parseFloat(document.getElementById("ieps").value) || 0;
        const precioFinal = parseFloat(document.getElementById("precioFinal").value.replace("$", "").trim()) || 0;
        
        const descuento = 0; 
        const importe = valorUnitario * cantidad - descuento;
        
        const tbody = document.getElementById("conceptos-body");
        const row = document.createElement("tr");
        row.innerHTML = `
            <td>${claveProductoServicio}</td>
            <td>${descripcion}</td>
            <td>${cantidad}</td>
            <td>${claveUnidad}</td>
            <td>${valorUnitario.toFixed(2)}</td>
            <td>${iva}</td>
            <td>${importe.toFixed(2)}</td>
            <td>${nombreInterno}</td>
            <td>${noIdentificacion}</td>
            <td>${objetoImpuesto}</td>
            <td>${isr}</td>                       
            <td>${ivaRetenido}</td>
            <td>${ieps}</td>
            <td>${precioFinal.toFixed(2)}</td>
            <td>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                <a class="btn btn-warning btn-sm editar-btn"><i class="fa-solid fa-pen-to-square"></i></a>
                <a class="btn btn-success btn-sm guardar-btn" style="display: none;"><i class="fa-solid fa-floppy-disk"></i></a>
                <a class="btn btn-danger btn-sm eliminar-btn"><i class="fa-solid fa-trash"></i></a>
                </div>
            </td>
        `;
        const btnEditar = row.querySelector(".editar-btn");
        const btnGuardar = row.querySelector(".guardar-btn");
        const btnEliminar = row.querySelector(".eliminar-btn");
        
        btnEditar.addEventListener("click", function () {
            editarDescripcion(row);
        });
        
        btnGuardar.addEventListener("click", function () {
            guardarDescripcion(row);
        });

        btnEliminar.addEventListener("click", function () {
        eliminarFila(row, importe, precioFinal - importe);
        });

        tbody.appendChild(row);
        actualizarCampoOculto();
        actualizarTotales(importe, precioFinal - importe);
        toggleModal(false);
    }
    
    
    function editarDescripcion(fila) {
        fila.cells[1].setAttribute("contenteditable", "true"); 
        fila.querySelector(".editar-btn").style.display = "none";
        fila.querySelector(".guardar-btn").style.display = "inline-block";
    }
    
    function guardarDescripcion(fila) {
        fila.cells[1].setAttribute("contenteditable", "false");
        
        fila.querySelector(".editar-btn").style.display = "inline-block";
        fila.querySelector(".guardar-btn").style.display = "none";
        actualizarDescripcionRecibo(fila);
        actualizarCampoOculto();
    }

    function eliminarFila(fila, importe, descuento) {
        fila.remove();
        actualizarTotales(-importe, -descuento);
        actualizarCampoOculto();
    }
    
    function actualizarDescripcionRecibo(fila) {
        const descripcionActualizada = fila.cells[1].innerText.trim(); // Obtener la nueva descripción
        const claveProductoServicio = fila.cells[0].innerText.trim(); // Usamos la clave como identificador
        
        // Buscar en la tabla del recibo la fila con la misma clave de producto/servicio
        const filasRecibo = document.querySelectorAll("#recibo tbody tr");
        
        filasRecibo.forEach(filaRecibo => {
            const claveRecibo = filaRecibo.cells[0].innerText.trim(); // Clave en la tabla del recibo
            if (claveRecibo === claveProductoServicio) {
                filaRecibo.cells[1].innerText = descripcionActualizada; // Actualizar la descripción en el recibo
            }
        });
    }
    document.getElementById("Formulario").addEventListener("submit", function (event) {
        actualizarCampoOculto();
        
        const productos = document.getElementById("productos-json").value;
        
        if (productos === "[]" || productos.trim() === "") {
            alert("Debe agregar al menos un producto antes de generar la factura.");
            event.preventDefault(); 
            return;
        }
        
        const formData = new FormData(this);
        formData.append("productos", productos);
        fetch("{{ route('dashboard.factura.generate', ['user' => 'id']) }}", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.errors) {
                let errorMessage = "Errores detectados:\n";
                for (let campo in data.errors) {
                    errorMessage += `- ${data.errors[campo].join(", ")}\n`;
                }
                alert(errorMessage);
            } else {
                alert("Factura enviada correctamente");
                window.location.reload(); 
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("Hubo un error al enviar los productos.");
        });
        
        event.preventDefault(); 
    });
    
    
    function actualizarTotales(importe, impuestos) { 
        const subtotalElem = document.getElementById("subtotal");
        const totalImpuestoElem = document.getElementById("totalImpuesto");
        const totalFinalElem = document.getElementById("totalFinal");
        
        // Obtener los valores actuales
        const currentSubtotal = parseFloat(subtotalElem.innerText.replace("$", "").trim()) || 0;
        const currentTotalImpuesto = parseFloat(totalImpuestoElem.innerText.replace("$", "").trim()) || 0;
        
        // Calcular los nuevos totales
        const nuevoSubtotal = currentSubtotal + importe;
        const nuevoTotalImpuesto = currentTotalImpuesto + impuestos;
        const nuevoTotalFinal = nuevoSubtotal + nuevoTotalImpuesto;
        
        // Actualizar el texto en la vista
        subtotalElem.innerText = `$ ${nuevoSubtotal.toFixed(2)}`;
        totalImpuestoElem.innerText = `$ ${nuevoTotalImpuesto.toFixed(2)}`;
        totalFinalElem.innerText = `$ ${nuevoTotalFinal.toFixed(2)}`;
        
        // Actualizar los campos ocultos para enviar al backend
        document.getElementById("subtotalInput").value = nuevoSubtotal.toFixed(2);
        document.getElementById("totalImpuestoInput").value = nuevoTotalImpuesto.toFixed(2);
        document.getElementById("totalFinalInput").value = nuevoTotalFinal.toFixed(2);
    }
    
    function toggleModal(show) {
        const modal = document.getElementById("modalNuevoProducto");
        modal.style.display = show ? "block" : "none";
        modal.classList.toggle("show", show);
    }
    
</script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const estadoSelect = document.getElementById("estado");
        const municipioSelect = document.getElementById("municipio");
        const coloniaSelect = document.getElementById("colonia");
        
        fetch("/get-estados")
        .then(response => response.json())
        .then(data => {
            estadoSelect.innerHTML = '<option value="">Selecciona un estado</option>';
            data.estados.forEach(estado => {
                let option = document.createElement("option");
                option.value = estado.ESTADO; 
                option.textContent = estado.ESTADO;
                estadoSelect.appendChild(option);
            });
        });
        
        estadoSelect.addEventListener("change", function () {
            let estadoNombre = this.value;
            municipioSelect.innerHTML = '<option value="">Cargando municipios...</option>';
            coloniaSelect.innerHTML = '<option value="">Selecciona un municipio primero</option>';
            
            if (estadoNombre) {
                fetch(`/get-municipios/${estadoNombre}`)
                .then(response => response.json())
                .then(data => {
                    municipioSelect.innerHTML = '<option value="">Selecciona un municipio</option>';
                    data.municipios.forEach(municipio => {
                        let option = document.createElement("option");
                        option.value = municipio.MUNICIPIO; // Guardamos el nombre
                        option.textContent = municipio.MUNICIPIO;
                        municipioSelect.appendChild(option);
                    });
                });
            }
        });
        
        municipioSelect.addEventListener("change", function () {
            let estadoNombre = estadoSelect.value;
            let municipioNombre = this.value;
            coloniaSelect.innerHTML = '<option value="">Cargando colonias...</option>';
            
            if (estadoNombre && municipioNombre) {
                fetch(`/get-colonias/${estadoNombre}/${municipioNombre}`)
                .then(response => response.json())
                .then(data => {
                    coloniaSelect.innerHTML = '<option value="">Selecciona una colonia</option>';
                    data.colonias.forEach(colonia => {
                        let option = document.createElement("option");
                        option.value = colonia.COLONIA;
                        option.textContent = colonia.COLONIA;
                        coloniaSelect.appendChild(option);
                    });
                });
            }
        });
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let objetoImpuesto = document.getElementById("objetoImpuesto");
        let cardImpuestos = document.getElementById("cardImpuestos");
        cardImpuestos.style.display = "none";
        
        objetoImpuesto.addEventListener("change", function() {
            if (this.value === "01") {
                cardImpuestos.style.display = "none";
            } else {
                cardImpuestos.style.display = "block";
            }
        });
    });
</script>

