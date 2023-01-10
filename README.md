# Zip Codes

Api que provee códigos postales de las entidades federativas de México. 

Actualizada a la versión 2023 que provee el Gobierno de México: https://www.correosdemexico.gob.mx/SSLServicios/ConsultaCP/CodigoPostal_Exportar.aspx

## Resolución del problema
Al momento de la publicación de esta API, se encontró que los códigos postales no cuentan con un servicio o API para acceder a este tipo de información.
Por lo tanto, se creo esta API para proporcionar este tipo de información.

Como no cuentan con un API, se tiene que descargar el archivo de todos los códigos postales e importarlo, este proceso es un tanto laborioso, ya que el archivo; ya sea en TXT, Excel o XML, contiene bastante información.
Para lograr esto, se desarrolo un comando, el cual genera los códigos postales a la base de datos, tomando como base el archivo XML que se descarga de la p{agina del Gobierno de México.

Una vez realizada la importación de la información, se consultan los datos actualizados de los códigos postales en el API.

### Proceso de actualización de Códigos Postales
1. Se descarga el archivo XML en la página de Gobierno de México
2. Se copia y se sobreescribe el archivo en la raíz del proyecto.
3. Se limpian las tablas correspondientes: zip_codes y settlements.
4. Se ejecuta el comando desde un ambiente local, y se importan las tablas a la base de datos de AWS: **sail artisan import:zipcodes**

## Stack de tecnologías
Como principal herramienta se utiliza **Laravel 9.31 y PHP 8.1**

- Laravel Vapor: Maneja la infraestructura por medio de AWS desde CLI. 
- Laravel Cache: Cachea los datos para optimizar el tiempo de respuesta y queries a la base de datos.
- Laravel Octane: Mejora el rendimiento de la aplicación usando Swoole con rutinas asíncronas.
- Git workflow: Flujo de trabajo de git para organizar los features y hotfixes
- Github: Para publicar el código fuente de la API.
- Postgres SQL: Base de datos para almacenar la información de los códigos postales.

## Ambiente Local

### Prerrequisitos
Se necesitan los siguiente prerrequisitos instalados para poder replicar el API en ambiente local:
- PHP 8.1
- Docker y Docker Compose
- Npm y Node
### Instalación
- Composer

1. Clonar el proyecto: **git clone https://github.com/krsrk/backbone.git zip-codes**
2. Cambiar al directorio del proyecto: **cd zip-codes**
3. Copiar el archivo de configuración: **cp .env.example .env**
4. Instalar las dependencias: **composer install**
5. Generar el APP Key del proyecto: php artisan key:generate
6. Instalar Laravel Sail: **php artisan sail:install**
7. Instalar Laravel Octane: **php artisan octane:install**

### Modificar archivos de configuración
1. Publicar los archivos de Docker de Laravel Sail: **php artisan sail:publish**
2. Publicar los archivos de configuración de Laravel Octane: **php artisan octane:publish**
3. Modificar el nombre del servicio "laravel.test" por "zip-codes" en el archivo docker-compose.yml
4. Modificar el supervisord.conf de Dockerfile(docker/8.1/supervisord.conf): 
```
[program:php]
command=/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan octane:start --server=swoole --host=0.0.0.0 --port=8000 --watch**
```
5. Modificar los puertos en el archivo **docker-compose.yml**:
```
ports:
    - '${APP_PORT:-8080}:8080'
    - '${VITE_PORT:-5173}:${VITE_PORT:-5173}'
    - "8036:8000"
```

### Construir las imágenes de Sail
1. Construir las imágenes de Docker: **sail build**
2. Una vez terminado el build: **sail up -d**
3. Probar el endpoint en local: **http://localhost:8086/api/zip-codes/20000





