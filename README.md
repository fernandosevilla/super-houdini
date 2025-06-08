# Super Houdini

**Gestor de Contraseñas Seguro con Zonas Compartidas y Funciones Inteligentes**

Super Houdini es una aplicación web construida con Laravel 12 y MySQL que permite gestionar, proteger y compartir contraseñas de forma segura.

---

## 📋 Requisitos previos

* PHP ≥ 8.1
* Composer
* Node.js ≥ 16 y npm
* MySQL ≥ 5.7 (o SQLite para desarrollo)
---

## 🚀 Instalación

1. **Clonar el repositorio**

   ```bash
   git clone https://github.com/fernandosevilla/super-houdini.git
   cd super-houdini
   ```

2. **Instalar dependencias de PHP**

   ```bash
   composer install
   ```

3. **Instalar dependencias de JavaScript y compilar assets**

   ```bash
   npm install
   npm run dev
   ```

4. **Configurar variables de entorno**

   Copia el fichero de ejemplo:

   ```bash
   cp .env.example .env
   ```

   Luego, elige la base de datos que vas a usar y ajusta las variables:

   * **SQLite** (Como está puesto en el .env.example):

     1. Crea el archivo de base de datos:

        ```bash
        touch database/database.sqlite
        ```
     2. Configura en `.env`:

        ```dotenv
        DB_CONNECTION=sqlite
        DB_DATABASE=${PWD}/database/database.sqlite
        DB_FOREIGN_KEYS=true
        ```
     3. Asegúrate de que la extensión SQLite de PHP esté habilitada.

   * **MySQL** (lo que se recomienda para producción):

     ```dotenv
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=super_houdini
     DB_USERNAME=usuario
     DB_PASSWORD=contraseña
     ```

5. **Generar clave de aplicación**

   ```bash
   php artisan key:generate
   ```

6. **Migrar la base de datos y ejecutar seeders**

   ```bash
   php artisan migrate --seed
   ```

---

## ⚙️ Ejecución local

* **Servidor integrado de Laravel**

  ```bash
  php artisan serve
  ```

  Accede en [http://localhost:8000](http://localhost:8000)

---

## 📅 Tareas programadas

Para habilitar la rotación automática de contraseñas y eliminación de enlaces caducados, habría que añadir el siguiente cron (sería para producción / en un entorno linux):

```cron
* * * * * cd /ruta/a/super-houdini && php artisan schedule:run >> /dev/null 2>&1
```

---
