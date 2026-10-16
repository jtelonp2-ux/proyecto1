# Sistema organizador de tareas escolares

Proyecto de Algoritmos, Universidad Mariano Gálvez de Guatemala.
Aplicación web con PHP (CodeIgniter 4) y Blade, arquitectura MVC.

## Requisitos

- Ubuntu/Lubuntu 22 o superior
- PHP 8.1 o superior (extensiones: intl, mbstring, mysql, xml, curl, zip)
- MySQL 8
- Composer
- Git

## Instalación

1. Clonar el repositorio:
   git clone https://github.com/jtelonp2-ux/proyecto1.git
   cd proyecto1

2. Instalar dependencias:
   composer install

3. Crear la base de datos y las tablas:
   sudo mysql < database/schema.sql

4. Crear un usuario de MySQL para la aplicación (cambiar usuario y clave):
   sudo mysql -e "CREATE USER 'mi_usuario'@'localhost' IDENTIFIED BY 'mi_clave'; GRANT ALL PRIVILEGES ON organizador.* TO 'mi_usuario'@'localhost'; FLUSH PRIVILEGES;"

5. Copiar la configuración y editar .env con ese usuario y clave:
   cp .env.example .env

6. Crear las carpetas de caché y de imágenes:
   mkdir -p writable/cache/blade
   mkdir -p public/uploads/avatars

7. Iniciar el servidor:
   php spark serve

8. Abrir http://localhost:8080 en el navegador.

## Configuración de correo (opcional)

La activación de cuenta y la recuperación de contraseña envían correos.
En .env completar las líneas email.* con una cuenta de Gmail y una
"contraseña de aplicación" (valor entre comillas y sin espacios).
Los enlaces de los correos apuntan a localhost:8080, por lo que deben
abrirse dentro de la misma máquina donde corre el servidor.

Si no se configura el correo, la cuenta se puede activar manualmente:

   sudo mysql -e "UPDATE organizador.users SET active = 1, activation_token = NULL WHERE email = 'correo@ejemplo.com';"

## Primer administrador

Registrar un usuario desde Sign up, activarlo (por correo o con el comando
anterior) y ejecutar:

   sudo mysql -e "UPDATE organizador.users SET administrator = 1 WHERE id = 1;"

## Funcionalidades

- Registro con activación por correo
- Inicio y cierre de sesión, con Remember me
- Recuperación de contraseña por correo
- Perfil: edición con confirmación de contraseña, cambio de contraseña e imagen de perfil
- Gestión de usuarios (solo administrador) con paginación Newer / Older
- Gestión de tareas con búsqueda y paginación
- Cambio de idioma (English / Español)
- Protección de rutas con filtros, tokens CSRF y contraseñas con hash
