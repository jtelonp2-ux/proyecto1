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

```
   git clone https://github.com/jtelonp2-ux/proyecto1.git
   cd proyecto1
```

2. Instalar dependencias:

```
   composer install
```

3. Crear la base de datos y las tablas:

```
   sudo mysql < database/schema.sql
```

4. Crear un usuario de MySQL para la aplicación (cambiar usuario y clave):

```
   sudo mysql -e "CREATE USER 'mi_usuario'@'localhost' IDENTIFIED BY 'mi_clave'; GRANT ALL PRIVILEGES ON organizador.* TO 'mi_usuario'@'localhost'; FLUSH PRIVILEGES;"
```

5. Copiar la configuración y editar `.env` con el usuario y la clave del paso anterior:

```
   cp .env.example .env
```

6. Crear la carpeta de caché de Blade:

```
   mkdir -p writable/cache/blade
```mkdir -p public/uploads/avatars

7. Iniciar el servidor:

```
   php spark serve
```

8. Abrir `http://localhost:8080` en el navegador.

## Primer administrador

Registrar un usuario desde Sign up y luego ejecutar:

```
sudo mysql -e "UPDATE organizador.users SET active = 1, administrator = 1 WHERE id = 1;"
```

## Funcionalidades

- Registro, inicio y cierre de sesión
- Perfil: edición con confirmación de contraseña y cambio de contraseña
- Gestión de usuarios (solo administrador)
- Gestión de tareas con búsqueda y paginación
- Cambio de idioma (English / Español)