# Requerimientos

* Php version 8.
* Motor de base de datos Mysql.
* Composer instalado


# Instrucciones

Después de descargar o clonar el repositorio y estar dentro de la carpeta raiz del proyecto ejecutar los siguientes comandos:
1)  **composer install**
El anterior comando es para instalar las dependencias del proyecto
2) **cp .env.example .env**
El comando anterior es para crear el archivo .env 
3) **php artisan key:generate**
El anterior comando genera la clave de la aplicacion de laravel
4) **php artisan jwt:secret**
El comando anterior genera una cadena que jwt usa para crear los tokens de acceso

## Agregar configuracion de base de datos
Abrir el archivo llamado **.env** y colocar valores a las variables de la base de datos
* DB_DATABASE (nombre de la base de datos mysql que debe estar creada)
* DB_USERNAME (el usuario d ela base de datos)
* DB_PASSWORD (la clave de tu base de datos)

## Migracion y datos por defecto

1) Despues de haber ocnfigurado el archivo **.env** se debe ejecutar la migracion para crear las tablas de la base de datos con el siguietne comando:
**php artisan migrate**

2) Crear usuario por defecto. Ejecutar el comando **php artisan db:seed --class=DefaultUserSeeder**
El anterior comando creara en la base de datos un usuario por defecto con las siguientes credenciales: 
* email: admin@admin.com
* password: 1234567

3) Ejecutar el comando **php artisan db:seed --class=DocumentTypeSeeder**
El comando anterior creará tipos de documento por defecto **CC** y **NIT**

4) Opcionalmente se pueden crear 100 usuarios de prueba con el comando
**php artisan db:seed --class=UserSeeder**
* Si se desea cambiar la cantidad de usuarios para crear se debe modificar el archivo en la carpeta **/database/seeders/UserSeeder.php** buscar la funcion **run** y modificar la parte donde dice **->count(100)** cambiando el numero 100 a la cantidad deseada.


## Ejecutar aplicacion

*Para ejecutar la aplicacion usar el comando **php artisan serve**

## Rutas de la api

La documentacion de la api se puede encontrar ingresando a la siguiente ruta:
**http://127.0.0.1:8000/api/documentation**

1. **/api/login**
Ruta que requiere el email y la contraseña del usuario para generar el token
2. **/api/document-types/create**
esta ruta retorna la lista de tipo documentos existentes.
3. **/api/document-types/create**
Esta ruta sirve para crear tipos de documento.
4. **api/users/create**
Esta ruta sirve para crear usuarios nuevos.
5. **/api/job-offers**
Esta ruta retorna el listado de ofertas laborales que tengan usuarios asociados
6. **/api/job-offers/create**
sirve para crear una oferta laboral, es necesario que se mande el listado de usuarios asociados