Proyecto FullStack PHP - Prueba de Entrevista
Descripción General
Este proyecto consiste en la implementación de una serie de servicios RESTful para la gestión de clientes (Customers) en una base de datos relacional. Se utilizan las herramientas provistas por el framework Lumen o Laravel para garantizar seguridad, control de accesos y una correcta estructura de middleware. El proyecto incluye autenticación, validaciones, y manejo de logs.

## Funcionalidades

- **Registro de Customers**: Crea un nuevo cliente asociado a una región y comuna, realizando todas las validaciones necesarias.
- **Consulta de Customers**: Permite consultar clientes por DNI o email, solo retornando aquellos que están activos.
- **Eliminación Lógica de Customers**: Elimina lógicamente un cliente, siempre que esté en estado activo o inactivo.
- **Autenticación**: Sistema de autenticación que genera un token con tiempo de vida, utilizado en todos los servicios.


Requerimientos
### Software
- PHP 8.3.11
- Lumen/Laravel 11
- Docker Desktop para la ejecución de contenedores.
- Thunder Client para pruebas de los servicios.


### Dependencias
- PHP >= 7.3
- Composer
- Extensiones de PHP: OpenSSL, PDO, Mbstring
- Lumen/Laravel


## Instalación

 1. Clona el repositorio desde GitHub:

```bash
   git clone https://github.com/erick-acosta/pruebaentrevista.git

o https

git clone https://github.com/erick-acosta/pruebaentrevista.git 

Dirígete al directorio del proyecto:

bash
Copiar código
cd proyecto
Instala las dependencias utilizando Composer:

bash
Copiar código
composer install
Configura el archivo .env copiando el .env.example:

"require": {
        "php": "^8.2",
        "laravel/framework": "^11.9",
        "laravel/sanctum": "^4.0",
        "laravel/tinker": "^2.9",
        "tymon/jwt-auth": "^2.1"
    },
    "require-dev": {
        "fakerphp/faker": "^1.23",
        "laravel/pint": "^1.13",
        "laravel/sail": "^1.26",
        "mockery/mockery": "^1.6",
        "nunomaduro/collision": "^8.0",
        "phpunit/phpunit": "^11.0.1"



bash
Copiar código
cp .env.example .env
Modifica las variables de entorno en el archivo .env con los valores correspondientes para tu entorno, asegurándote de configurar la conexión a la base de datos y el parámetro APP_DEBUG en false si estás en producción.

Ejecuta las migraciones de la base de datos:

bash
Copiar código
php artisan migrate
Levanta el contenedor Docker para el ambiente de desarrollo:



bash

docker ps 

Servicios
Autenticación
Ruta: /api/login
Método: POST
Descripción: Permite el inicio de sesión de un usuario y genera un token de autenticación con tiempo de vida.

Parámetros de entrada:

json
Copiar código
{
    "email": "string",
    "password": "string"
}
Respuesta:

success: true o false
token: Token de autenticación (SHA1 encriptado)
Registro de Customer
Ruta: /api/customers
Método: POST
Descripción: Registra un nuevo customer en el sistema.

Parámetros de entrada:

json
Copiar código
{
    "dni": "string",
    "email": "string",
    "name": "string",
    "last_name": "string",
    "address": "string",
    "id_reg": "int",
    "id_com": "int"
}
Respuesta:

success: true o false
mensaje: Detalle del resultado del registro
Consultar Customer
Ruta: /api/customers/search
Método: GET
Descripción: Consulta de customer por DNI o email. Retorna solo clientes activos.

Parámetros de entrada:

dni: opcional, número de documento de identidad.
email: opcional, dirección de correo electrónico.
Respuesta:

json
Copiar código
{
    "success": true,
    "data": {
        "name": "string",
        "last_name": "string",
        "address": "string|null",
        "region": "string",
        "commune": "string"
    }
}
Eliminar Customer
Ruta: /api/customers/delete
Método: DELETE
Descripción: Elimina lógicamente un customer.

Parámetros de entrada:

json
Copiar código
{
    "dni": "string"
}
Respuesta:

success: true o false
mensaje: Detalle del resultado de la eliminación.
Seguridad
Validaciones: Todas las validaciones de campos obligatorios y existencia de información están gestionadas a través de middlewares.
Protección contra Inyección SQL: Las consultas están protegidas mediante el uso de Eloquent ORM.
Autenticación: Utilización de tokens SHA1 encriptados generados durante el inicio de sesión. Este token debe ser enviado en cada petición y validado en el middleware de autenticación.
Logs
Los logs de entrada y salida de información se gestionan mediante archivos de texto plano o en una base de datos, según configuración.
Se registra la dirección IP desde la que proviene la solicitud.
En el entorno de producción, definido en el archivo .env, solo se registran logs de entrada.
Modelo de Base de Datos
regions: Almacena las regiones disponibles en el sistema.
communes: Comunas relacionadas a las regiones.
customers: Información de los clientes, incluyendo estado (activo, inactivo, eliminado).

sql
Copiar código
CREATE TABLE IF NOT EXISTS `regions` (
    `id_reg` INT NOT NULL AUTO_INCREMENT,
    `description` VARCHAR(90) NOT NULL,
    `status` ENUM('A', 'I', 'trash') NOT NULL DEFAULT 'A',
    PRIMARY KEY (`id_reg`)
);

CREATE TABLE IF NOT EXISTS `communes` (
    `id_com` INT NOT NULL AUTO_INCREMENT,
    `id_reg` INT NOT NULL,
    `description` VARCHAR(90) NOT NULL,
    `status` ENUM('A', 'I', 'trash') NOT NULL DEFAULT 'A',
    PRIMARY KEY (`id_com`, `id_reg`)
);

CREATE TABLE IF NOT EXISTS `customers` (
    `dni` VARCHAR(45) NOT NULL,
    `id_reg` INT NOT NULL,
    `id_com` INT NOT NULL,
    `email` VARCHAR(120) NOT NULL,
    `name` VARCHAR(45) NOT NULL,
    `last_name` VARCHAR(45) NOT NULL,
    `address` VARCHAR(255) NULL,
    `date_reg` DATETIME NOT NULL,
    `status` ENUM('A', 'I', 'trash') NOT NULL DEFAULT 'A',
    PRIMARY KEY (`dni`, `id_reg`, `id_com`),
    UNIQUE (`email`)
);
Despliegue

El despliegue se realizará en un servidor de producción con el entorno definido
Realiza pruebas de los servicios utilizando Thunder Client o Postman.
Si es necesario, configura el entorno para despliegue en producción, asegurándote de desactivar los logs de salida con el parámetro APP_DEBUG=false.
Conclusión
Este proyecto ofrece una solución robusta para la gestión de clientes, asegurando la integridad de los datos, seguridad y facilidad de uso mediante una API bien estructurada y documentada.
