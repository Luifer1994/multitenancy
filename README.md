<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

## PASOS DE INSTALACIÓN

### Configuración

1. Instala las dependencias ejecutando el siguiente comando: `composer install`.
2. Ejecuta las migraciones para el proyecto central con el siguiente comando: `php artisan migrate --path=database/migrations/central --seed`.
   Ten en cuenta que al crear nuevas migraciones para el paquete central, deberás ubicarlas dentro de la ruta `database/migrations/central`
   y ejecutarlas con el comando `php artisan migrate --path=database/migrations/central`.
3. Ejecuta el siguiente comando para crear los permisos iniciales: `php artisan create create-permissions`.
4. Las migraciones de los inquilinos (tenants) se encuentran en la ruta `database/migrations/tenant`. Es decir, cada vez que crees migraciones para
   los inquilinos, guárdalas dentro de esta ruta y ejecútalas con uno de los siguientes comandos: `php artisan tenants:migrate` o
   `php artisan migrate --path=database/migrations/tenant`. Al crear un inquilino nuevo, el sistema creará su base de datos automáticamente y
   ejecutará las migraciones.
5. Cuando se creen nuevos permisos para los inquilinos, ejecuta el siguiente comando: `php artisan create create-permissions-tenants`.
