# Backend App - Laravel API

Este es el backend del proyecto **GourmetGo!** desarrollado con Laravel.

## 🚀 Pasos para la configuración inicial

Sigue estos pasos para configurar tu entorno de desarrollo local:

### 1. Instalar dependencias
Primero, descarga todas las librerías necesarias de PHP (esto creará la carpeta `vendor/`):
```bash
composer install
```
### 2. Configurar el entorno
Copia el archivo de ejemplo para crear tu archivo de configuración real:
```bash
cp .env.example .env
```
### 3. Generar claves de seguridad
Genera la clave de la aplicación y la clave de firma para los tokens JWT:
```bash
php artisan key:generate
```
```bash
php artisan jwt:secret
```
### 4. Configuración de Base de Datos (PostgreSQL)
Abre el archivo .env y asegúrate de que los datos de conexión sean correctos:
```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=GourmetGO
DB_USERNAME=postgres
DB_PASSWORD=tucontraseña
```
### 5. Ejecutar Migraciones
Una vez configurada la base de datos, crea las tablas:
```bash
php artisan migrate
```
### 6. Ejecutar Server
Iniciar el servidor local:
```bash
php artisan serve
```