# Guía de Instalación y Actualización - Grow CRM

Esta guía te ayudará a configurar y mantener el proyecto Grow CRM en tu entorno local.

## 📋 Tabla de Contenidos

1. [Requisitos Previos](#requisitos-previos)
2. [Instalación Inicial](#instalación-inicial)
3. [Configuración del Entorno](#configuración-del-entorno)
4. [Instalación con Docker](#instalación-con-docker)
5. [Actualización del Sistema](#actualización-del-sistema)
6. [Solución de Problemas](#solución-de-problemas)

---

## Requisitos Previos

Antes de comenzar, asegúrate de tener instalado:

### Software Requerido

- **PHP** >= 7.2 (recomendado PHP 8.2)
- **Composer** (gestor de dependencias de PHP)
- **Node.js** >= 12.13.0 y **npm** (para compilar assets)
- **MySQL** >= 5.7 o **MariaDB** >= 10.3 (base de datos)
- **Git** (para clonar el repositorio si es necesario)

### Verificar Instalaciones

```bash
php -v          # Debe mostrar PHP 7.2 o superior
composer -V      # Debe mostrar la versión de Composer
node -v          # Debe mostrar Node.js 12.13.0 o superior
npm -v           # Debe mostrar la versión de npm
mysql --version  # Debe mostrar MySQL o MariaDB
```

### Extensiones PHP Requeridas

Asegúrate de tener instaladas las siguientes extensiones:

- `pdo_mysql` - Conexión a MySQL
- `zip` - Manejo de archivos ZIP
- `mbstring` - Manipulación de strings multibyte
- `exif` - Metadatos de imágenes
- `pcntl` - Control de procesos
- `bcmath` - Cálculos matemáticos de precisión
- `gd` - Manipulación de imágenes
- `xml` - Procesamiento XML
- `openssl` - Encriptación SSL/TLS
- `curl` - Cliente HTTP

**Verificar extensiones:**
```bash
php -m | grep -E "pdo_mysql|zip|mbstring|gd|xml|openssl"
```

**Instalar en Ubuntu/Debian:**
```bash
sudo apt-get install php-pdo php-mysql php-zip php-mbstring php-exif php-bcmath php-gd php-xml php-curl
```

**Instalar en macOS (Homebrew):**
```bash
brew install php@8.2
```

---

## Instalación Inicial

### Paso 1: Clonar/Preparar el Proyecto

Si estás clonando desde un repositorio:
```bash
git clone [url-del-repositorio] grow
cd grow
```

Si ya tienes el proyecto, navega a la carpeta:
```bash
cd /Users/gbetus/Development/crm/grow
```

### Paso 2: Configurar la Base de Datos

1. **Accede a MySQL:**
```bash
mysql -u root -p
```

2. **Crea las bases de datos necesarias:**
```sql
-- Base de datos para tenants (clientes)
CREATE DATABASE grow_crm CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Base de datos para landlord (administración multi-tenant)
CREATE DATABASE grow_landlord CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Verifica que se crearon correctamente
SHOW DATABASES;

EXIT;
```

3. **Importa el archivo SQL inicial (si existe):**
```bash
mysql -u root -p grow_crm < growsaas-tenant.sql
``` 
```bash
mysql -u root -p grow_landlord < growsaas-landlord.sql
```

### Paso 3: Instalar Dependencias de PHP

1. **Navega a la carpeta `application`:**
```bash
cd application
```

2. **Instala las dependencias de Composer:**
```bash
composer install
```

Si tienes problemas de memoria o tiempo, usa:
```bash
composer install --no-interaction --no-scripts --prefer-dist
```

**Nota:** El proceso puede tardar varios minutos dependiendo de tu conexión.

### Paso 4: Configurar Variables de Entorno

1. **Crea el archivo `.env`:**
```bash
# Si existe .env.example
cp .env.example .env

# Si no existe, crea un archivo .env nuevo
touch .env
```

2. **Edita el archivo `.env`** con tu editor preferido y configura:

```env
# ============================================
# CONFIGURACIÓN BÁSICA DE LA APLICACIÓN
# ============================================
APP_NAME="Grow CRM"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# ============================================
# CONFIGURACIÓN DE LOGS
# ============================================
LOG_CHANNEL=stack
LOG_LEVEL=debug

# ============================================
# CONFIGURACIÓN DE BASE DE DATOS
# ============================================
# IMPORTANTE: Este proyecto usa un sistema especial de configuración
# Debes configurar DB_METHOD para indicar el método de conexión

# Método de conexión: 'mysql_user', 'cpanel', o 'plesk'
# Para desarrollo local, usa 'mysql_user'
DB_METHOD=mysql_user

# Configuración para DB_METHOD=mysql_user (desarrollo local)
DB_METHOD_MYSQL_HOST=127.0.0.1
DB_METHOD_MYSQL_PORT=3306
DB_METHOD_MYSQL_USER=root
DB_METHOD_MYSQL_PASSWORD=tu_password_aqui

# Si usas cPanel, configura estas variables:
# DB_METHOD=cpanel
# DB_METHOD_CPANEL_HOST=tu_host
# DB_METHOD_CPANEL_PORT=3306
# DB_METHOD_CPANEL_USER=tu_usuario
# DB_METHOD_CPANEL_PASSWORD=tu_password

# Si usas Plesk, configura estas variables:
# DB_METHOD=plesk
# DB_METHOD_PLESK_HOST=tu_host
# DB_METHOD_PLESK_PORT=3306
# DB_METHOD_PLESK_USERNAME=tu_usuario
# DB_METHOD_PLESK_PASSWORD=tu_password

# ============================================
# CONFIGURACIÓN DE BASE DE DATOS - LANDLORD
# ============================================
LANDLORD_DB_DATABASE=grow_landlord

# ============================================
# CONFIGURACIÓN DE BASE DE DATOS - TENANT (Desarrollo Local)
# ============================================
# IMPORTANTE: Esta variable es necesaria para desarrollo local
# En producción, el sistema selecciona la base de datos dinámicamente
TENANT_DB_DATABASE=grow_crm

# ============================================
# CONFIGURACIÓN DE CACHE Y SESIONES
# ============================================
BROADCAST_DRIVER=log
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# ============================================
# CONFIGURACIÓN DE REDIS (Opcional)
# ============================================
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

# ============================================
# CONFIGURACIÓN DE CORREO
# ============================================
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=noreply@growcrm.local
MAIL_FROM_NAME="${APP_NAME}"

# ============================================
# CONFIGURACIÓN ADICIONAL
# ============================================
TIMEZONE=America/Mexico_City
LOCALE=es
```

3. **Genera la clave de aplicación:**
```bash
php artisan key:generate
```

Esto actualizará automáticamente el `APP_KEY` en tu archivo `.env`.

### Paso 5: Configurar Permisos

Asegúrate de que las carpetas de almacenamiento tengan los permisos correctos:

```bash
# Desde la raíz del proyecto
cd /Users/gbetus/Development/crm/grow

# Configurar permisos
chmod -R 775 storage
chmod -R 775 application/storage
chmod -R 775 application/bootstrap/cache

# Si estás en Linux/macOS y necesitas cambiar el propietario
sudo chown -R $USER:$USER storage application/storage application/bootstrap/cache
```

### Paso 6: Instalar Dependencias de Node.js

1. **Desde la carpeta `application`:**
```bash
cd application
npm install
```

**Nota:** Si tienes problemas con versiones antiguas de Node.js, puedes usar:
```bash
npm install --legacy-peer-deps
```

2. **Compila los assets:**
```bash
# Para desarrollo
npm run dev

# Para producción
npm run production

# Para desarrollo con watch (recarga automática)
npm run watch
```

### Paso 7: Ejecutar Migraciones

**IMPORTANTE:** Este proyecto usa multitenancy, por lo que las migraciones deben ejecutarse en un orden específico:

1. **Primero, ejecuta las migraciones del landlord (base de datos principal):**
```bash
php artisan migrate --database=landlord
```

2. **Luego, ejecuta las migraciones de los tenants:**
```bash
# Si ya tienes tenants configurados:
php artisan tenants:migrate --tenants=all

# O si es una instalación nueva y necesitas migrar la conexión tenant:
php artisan migrate --database=tenant
```

**Nota:** Si necesitas refrescar la base de datos (¡CUIDADO! Esto borra todos los datos):
```bash
# Solo para desarrollo - borra y recrea las tablas
php artisan migrate:fresh --database=landlord
php artisan migrate:fresh --database=tenant
```

### Paso 8: Iniciar el Servidor de Desarrollo

**IMPORTANTE:** Este proyecto tiene una estructura especial donde la carpeta `public` está en la raíz, no dentro de `application`. El comando `php artisan serve` no funcionará directamente porque busca `public` dentro de `application`.

**Solución: Usar el servidor PHP integrado desde la raíz del proyecto**

```bash
# Navega a la raíz del proyecto
cd /Users/gbetus/Development/crm/grow

# Inicia el servidor PHP integrado
php -S localhost:8000 -t public
```

O si prefieres usar una IP específica:
```bash
php -S 127.0.0.1:8000 -t public
```

El proyecto estará disponible en: **`http://localhost:8000`** o **`http://127.0.0.1:8000`**

**Nota:** El archivo `index.php` en la raíz del proyecto está configurado para funcionar con esta estructura, así que el servidor PHP integrado funcionará correctamente.

### Paso 9: Acceder al Instalador Web (Opcional)

El proyecto incluye un instalador web que facilita la configuración:

1. Accede a: `http://localhost:8000/install`
2. Sigue las instrucciones del instalador:
   - Verificación de requisitos
   - Configuración de base de datos
   - Configuración de la aplicación
   - Creación de usuario administrador

---

## Instalación con Docker

### Opción A: Usando el Dockerfile Principal

1. **Construir la imagen:**
```bash
docker build -f Dockerfile -t grow-crm .
```

2. **Ejecutar el contenedor:**
```bash
docker run -d \
  -p 80:80 \
  -v $(pwd):/var/www/html \
  --name grow-crm \
  grow-crm
```

### Opción B: Usando el Dockerfile de Dockerizer

1. **Construir la imagen:**
```bash
docker build -f dockerizer/Dockerfile -t grow-crm .
```

2. **Ejecutar el contenedor:**
```bash
docker run -d \
  -p 80:80 \
  -v $(pwd):/app \
  --name grow-crm \
  grow-crm
```

3. **Acceder al contenedor:**
```bash
docker exec -it grow-crm bash
```

4. **Dentro del contenedor, ejecuta:**
```bash
cd /app/application
composer install
npm install
php artisan key:generate
php artisan migrate
```

### Docker Compose (Recomendado)

Crea un archivo `docker-compose.yml` en la raíz:

```yaml
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: dockerizer/Dockerfile
    ports:
      - "8000:80"
    volumes:
      - .:/app
    environment:
      - DB_HOST=db
      - DB_DATABASE=grow_crm
      - DB_USERNAME=grow_user
      - DB_PASSWORD=grow_password
    depends_on:
      - db

  db:
    image: mysql:8.0
    ports:
      - "3306:3306"
    environment:
      MYSQL_DATABASE: grow_crm
      MYSQL_USER: grow_user
      MYSQL_PASSWORD: grow_password
      MYSQL_ROOT_PASSWORD: root_password
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

Ejecuta:
```bash
docker-compose up -d
```

---

## Actualización del Sistema

### Proceso de Actualización Automática

El sistema incluye un cronjob que ejecuta actualizaciones automáticamente. Los archivos de actualización se encuentran en:
- `application/updating/updating_1.php` hasta `updating_10.php`

### Actualización Manual

1. **Haz backup de la base de datos:**
```bash
mysqldump -u root -p grow_crm > backup_$(date +%Y%m%d_%H%M%S).sql
mysqldump -u root -p grow_landlord > backup_landlord_$(date +%Y%m%d_%H%M%S).sql
```

2. **Actualiza el código:**
```bash
# Si usas Git
git pull origin main

# O descarga la nueva versión y reemplaza los archivos
```

3. **Actualiza dependencias:**
```bash
cd application
composer update
npm update
npm run production
```

4. **Ejecuta migraciones:**
```bash
php artisan migrate
```

5. **Limpia cachés:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

6. **Optimiza la aplicación:**
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Verificar Estado de Actualizaciones

El sistema registra las actualizaciones en la base de datos. Puedes verificar el estado:

```bash
php artisan tinker
```

```php
// Ver logs de actualizaciones
DB::connection('landlord')->table('updates_log')->get();
```

### Actualización de Tenants (Multi-tenant)

Si el sistema detecta actualizaciones pendientes para tenants, el cronjob `UpdatingCron` las procesará automáticamente. Para ejecutar manualmente:

```bash
php artisan schedule:run
```

O ejecuta el cronjob directamente:
```bash
php artisan tinker
```

```php
(new \App\Cronjobs\UpdatingCron)->handle();
```

---

## Solución de Problemas

### Error: "Class 'PDO' not found"

**Solución:**
```bash
# Ubuntu/Debian
sudo apt-get install php-pdo php-mysql

# macOS con Homebrew
brew install php@8.2
```

### Error de Permisos

**Solución:**
```bash
sudo chown -R $USER:$USER storage application/storage application/bootstrap/cache
chmod -R 775 storage application/storage application/bootstrap/cache
```

### Error: "SQLSTATE[HY000] [2002] No such file or directory"

**Causa:** MySQL no está corriendo o la configuración es incorrecta.

**Solución:**
```bash
# Verificar que MySQL esté corriendo
sudo service mysql status
# o
brew services list | grep mysql

# Iniciar MySQL si no está corriendo
sudo service mysql start
# o
brew services start mysql

# Verificar credenciales en .env
```

### Error: "The stream or file could not be opened"

**Causa:** Permisos incorrectos en la carpeta de logs.

**Solución:**
```bash
mkdir -p application/storage/logs
chmod -R 775 application/storage/logs
```

### Error al compilar assets

**Solución:**
```bash
# Verificar versiones
node -v  # Debe ser >= 12.13.0
npm -v

# Limpiar e reinstalar
rm -rf node_modules package-lock.json
npm install

# Si persiste, usar versión legacy
npm install --legacy-peer-deps
```

### Error: "Composer memory limit"

**Solución:**
```bash
# Aumentar límite de memoria para Composer
php -d memory_limit=-1 /usr/local/bin/composer install
```

### Error: "No application encryption key has been specified"

**Solución:**
```bash
cd application
php artisan key:generate
```

### Error: "The provided cwd does not exist" al ejecutar `php artisan serve`

**Causa:** El proyecto tiene la carpeta `public` en la raíz, no dentro de `application`. El comando `php artisan serve` busca `public` dentro de `application`.

**Solución:**
Usa el servidor PHP integrado desde la raíz del proyecto:
```bash
cd /Users/gbetus/Development/crm/grow
php -S localhost:8000 -t public
```

Esto iniciará el servidor correctamente usando el `index.php` de la raíz.

### Error: "Access denied for user 'undefined'@'localhost'"

**Causa:** El proyecto usa un sistema especial de configuración de base de datos. Si no configuras `DB_METHOD`, las funciones devuelven 'undefined' como usuario.

**Solución:**
1. Verifica que tengas configurado `DB_METHOD` en tu `.env`:
```env
DB_METHOD=mysql_user
DB_METHOD_MYSQL_HOST=127.0.0.1
DB_METHOD_MYSQL_PORT=3306
DB_METHOD_MYSQL_USER=root
DB_METHOD_MYSQL_PASSWORD=tu_password
```

2. Limpia la caché de configuración:
```bash
php artisan config:clear
php artisan cache:clear
```

3. Verifica que las variables estén cargadas:
```bash
php artisan tinker
```

```php
env('DB_METHOD');
env('DB_METHOD_MYSQL_USER');
```

### Problemas con Multitenancy

Si tienes problemas con el sistema multi-tenant:

1. Verifica que ambas bases de datos existan:
```sql
SHOW DATABASES;
```

2. Verifica la configuración en `.env`:
```env
DB_METHOD=mysql_user
DB_METHOD_MYSQL_HOST=127.0.0.1
DB_METHOD_MYSQL_USER=root
DB_METHOD_MYSQL_PASSWORD=tu_password
LANDLORD_DB_DATABASE=grow_landlord
```

3. Verifica las conexiones:
```bash
php artisan tinker
```

```php
DB::connection('landlord')->getPdo();
DB::connection('tenant')->getPdo();
```

### Error: "No database selected" (Connection: tenant)

**Causa:** La conexión `tenant` tiene `database => null` porque en sistemas multi-tenant la base de datos se selecciona dinámicamente. Para desarrollo local, necesitas especificar una base de datos.

**Solución 1: Usar el Instalador Web (Recomendado)**

El instalador web maneja automáticamente la configuración de bases de datos:
1. Accede a: `http://localhost:8000/install`
2. Sigue el asistente de instalación que configurará todo automáticamente

**Solución 2: Modificar temporalmente la configuración para desarrollo**

1. Edita `application/config/database.php` y modifica la conexión tenant:

```php
'tenant' => [
    'driver' => 'mysql',
    'host' => env_db_host(),
    'port' => env_db_port(),
    'database' => env('TENANT_DB_DATABASE', 'grow_crm'), // Agrega esta línea
    'username' => env_db_user(),
    'password' => env_db_password(),
    // ... resto de la configuración
],
```

2. Agrega en tu `.env`:
```env
TENANT_DB_DATABASE=grow_crm
```

3. Limpia la caché:
```bash
php artisan config:clear
```

4. Ejecuta las migraciones:
```bash
php artisan migrate --database=landlord
php artisan migrate --database=tenant
```

**Solución 3: Ejecutar migraciones solo del landlord primero**

Si solo necesitas el landlord funcionando inicialmente:
```bash
php artisan migrate --database=landlord
```

Luego usa el instalador web para configurar los tenants.

---

## Estructura del Proyecto

```
grow/
├── application/          # Código fuente de Laravel
│   ├── app/             # Lógica de la aplicación
│   ├── config/          # Archivos de configuración
│   ├── database/        # Migraciones y seeds
│   ├── resources/       # Vistas y assets
│   ├── routes/          # Rutas de la aplicación
│   ├── storage/         # Archivos de almacenamiento
│   └── updating/        # Scripts de actualización
├── public/              # Archivos públicos (CSS, JS, imágenes)
├── storage/             # Archivos de almacenamiento global
├── dockerizer/          # Configuraciones de Docker
└── index.php           # Punto de entrada de la aplicación
```

---

## Comandos Útiles

### Desarrollo

```bash
# Iniciar servidor de desarrollo (desde la raíz del proyecto)
cd /Users/gbetus/Development/crm/grow
php -S localhost:8000 -t public

# Compilar assets en modo watch (desde application)
cd application
npm run watch

# Ver logs en tiempo real
tail -f application/storage/logs/laravel.log
```

### Mantenimiento

```bash
# Limpiar todas las cachés
php artisan optimize:clear

# Optimizar aplicación
php artisan optimize

# Ver rutas registradas
php artisan route:list

# Ver configuración actual
php artisan config:show
```

### Base de Datos

```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Ver estado de migraciones
php artisan migrate:status

# Crear nueva migración
php artisan make:migration nombre_de_la_migracion
```

---

## Próximos Pasos Después de la Instalación

1. ✅ Accede al instalador web: `http://localhost:8000/install`
2. ✅ Completa la configuración inicial
3. ✅ Crea un usuario administrador
4. ✅ Configura los módulos necesarios
5. ✅ Revisa la documentación en `Documentation.pdf`
6. ✅ Explora el sistema y familiarízate con las funcionalidades

---

## Notas Importantes

- ⚠️ Este proyecto usa **multitenancy** (multi-inquilino), por lo que necesitas configurar tanto la base de datos `tenant` como `landlord`
- ⚠️ El proyecto puede tener un sistema de instalación web que facilita la configuración inicial
- ⚠️ Asegúrate de tener suficiente memoria PHP configurada (recomendado: 256M o más)
- ⚠️ En producción, cambia `APP_DEBUG=false` y `APP_ENV=production`
- ⚠️ Siempre haz backup antes de ejecutar actualizaciones
- ⚠️ El sistema ejecuta actualizaciones automáticamente mediante cronjobs

---

## Soporte y Recursos

### Logs del Sistema

- Logs de Laravel: `application/storage/logs/laravel.log`
- Logs de actualizaciones: Base de datos `updates_log` (tabla en landlord)

### Verificar Configuración

```bash
# Ver información de PHP
php -i

# Ver configuración de Laravel
php artisan config:show

# Verificar requisitos del sistema
php artisan about
```

### Contacto y Documentación

- Revisa `Documentation.pdf` para documentación completa
- Verifica los logs en caso de errores
- Consulta la documentación oficial de Laravel: https://laravel.com/docs

---

## Checklist de Instalación

- [ ] PHP >= 7.2 instalado y configurado
- [ ] Composer instalado
- [ ] Node.js y npm instalados
- [ ] MySQL/MariaDB instalado y corriendo
- [ ] Bases de datos creadas (grow_crm y grow_landlord)
- [ ] Dependencias de Composer instaladas
- [ ] Dependencias de npm instaladas
- [ ] Archivo `.env` configurado
- [ ] `APP_KEY` generado
- [ ] Permisos de carpetas configurados
- [ ] Assets compilados
- [ ] Migraciones ejecutadas
- [ ] Servidor funcionando
- [ ] Instalador web accesible (opcional)

---

**¡Feliz desarrollo! 🚀**
