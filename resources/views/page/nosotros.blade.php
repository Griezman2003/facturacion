@extends('auth.master')
@section('contenido')
<div class="container-md mt-5 p-4 border rounded shadow bg-light">
    <div class="row">
        <a class="text-decoration-none mb-3" style="display: flex; justify-content: end;" href="/">← Volver</a>
    </div>
    
    <div class="row text-center">
        <h1 class="mb-4">Acerca de Nosotros</h1>
        <p class="lead" style="text-align: justify;">
            <h5 class="text-center">Sistema de Facturación Digital - Universidad Tecnológica de Candelaria</h5><br>
            
            En la Universidad Tecnológica de Candelaria, la innovación y el aprendizaje son parte fundamental de nuestra formación. Por ello, como estudiantes de la carrera de Ingeniería en Desarrollo y Gestión de Software, hemos creado este Sistema de Facturación Digital, un proyecto diseñado para optimizar y facilitar la gestión contable y administrativa de las empresas y emprendedores.
            
            ¿Cuál es nuestro objetivo?
            Nuestro propósito es ofrecer una herramienta eficiente, segura y moderna que permita a los usuarios gestionar sus facturas de forma ágil y cumplir con las disposiciones fiscales vigentes en México. Este sistema es el resultado del conocimiento adquirido durante nuestra formación, aplicando las mejores prácticas en desarrollo de software y normativas fiscales.
            
            ¿Qué ofrece nuestro sistema?
            Generación automática de facturas electrónicas bajo el estándar CFDI 4.0.
            Cálculo preciso de impuestos como IVA, ISR e IVA retenido.
            Gestión organizada de clientes, productos y servicios.
            Interfaz intuitiva que facilita el uso tanto para pequeñas empresas como para usuarios independientes.
            Nuestra visión
            Buscamos que este sistema sea una herramienta clave para la digitalización de procesos contables en la región, ayudando a empresas a cumplir con sus obligaciones fiscales de forma sencilla, segura y eficiente.
            
            Un proyecto hecho con dedicación
            Este sistema es el reflejo del esfuerzo, el trabajo en equipo y el compromiso de los futuros ingenieros en software: Gamaliel García, Eddy Cordero y Jesus Balan, quienes con dedicación y pasión lograron consolidar este proyecto para beneficio de nuestra comunidad.
            
            Contáctanos
            Si tienes preguntas, sugerencias o deseas conocer más sobre el sistema, no dudes en ponerte en contacto con nosotros.
            
            ¡Gracias por confiar en el talento de los estudiantes de la Universidad Tecnológica de Candelaria!
        </p>
    </div>
    
    <div class="row text-center mt-4">
        <h5>Contactanos al:</h5>
        <div class="d-flex justify-content-center mt-2">
            <img src="https://media.istockphoto.com/id/1130588880/es/vector/icono-de-tel%C3%A9fono-negro-sobre-fondo-blanco-ilustraci%C3%B3n-de-vector.jpg?s=612x612&w=0&k=20&c=Ro4R5Q-rhaQ_PiHVcnxLTISCH763FvvKECavBitvGgY=" 
            alt="Teléfono" 
            style="width: 40px; height: 40px; margin-right: 8px;">
            <p style="font-size: 1.5rem; font-weight: bold;">9822659839</p>
        </div>
    </div>
</div>
@endsection