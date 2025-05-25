# Facturación | ING. Desarrollo y Gestión de Software

Sistema de facturación desarrollado con el framework Laravel, orientado a aplicaciones académicas y empresariales. Este proyecto forma parte la estadia profesional
de Ingeniería en Desarrollo y Gestión de Software. Enero - Mayo 2025 

------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## 🚀 Requisitos del sistema

- **PHP >= 8.1**
- **Composer**
- **MySQL o MariaDB**
- **Node.js y npm** (opcional, para compilar assets con Vite)
- **Laravel 10+**
- **Servidor local: Laragon, XAMPP, WAMP o similar**

------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## ⚙️ Instalación paso a paso

### 1. Clona el repositorio

**git clone https://github.com/Griezman2003/facturacion.git**

- **cd facturacion**

### 📦 2. Instalar dependencias de Laravel

- **composer install**

### 📋 3. Copiar el archivo .env

- **cp .env.example .env**

### 🔐 4. Generar la clave de la aplicación

- **php artisan key:generate**

### 📂 5. Crear una base de datos

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=facturacion_db
DB_USERNAME=tu_usuario
DB_PASSWORD=tu_contraseña

### 6. Iniciar el servidor local de Laravel

- **php artisan serve**

------------------------------------------------------------------------------------------------------------------------------------------------------------------------

## 👨‍💻 Autor
Gamaliel Garcia
Ingeniería en Desarrollo y Gestión de Software
Email: [tu-email@example.com]
GitHub: [https://github.com/tu_usuario]