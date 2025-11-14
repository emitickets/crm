# --- Etapa 1: Builder ---
# Esta etapa solo instala dependencias de Composer (los assets ya están compilados)

FROM php:8.2-cli-alpine AS builder

# Instalar dependencias del sistema necesarias para Composer y extensiones PHP
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    oniguruma-dev \
    libxml2-dev

# Instalar extensiones de PHP necesarias (zip, gd, mbstring, etc.)
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        zip \
        gd \
        mbstring \
        pdo_mysql \
        exif \
        pcntl \
        bcmath

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto (desde la raíz del proyecto)
# NOTA: Este Dockerfile debe ejecutarse desde la raíz con: docker build -f dockerizer/Dockerfile .
WORKDIR /app
COPY . /app

# Instalar dependencias de Composer (incluyendo dev)
WORKDIR /app/application
RUN composer install --optimize-autoloader --no-interaction

# --- Etapa 2: Production ---
# Esta etapa usa la imagen de webdevops y copia los archivos

FROM webdevops/php-nginx:8.2

# Copiar los archivos de la aplicación desde el builder
COPY --from=builder /app /app

# Configurar Nginx para Laravel
# Este proyecto tiene index.php en la raíz, no en /public
# La imagen base webdevops/php-nginx usa variables de entorno para configurar el vhost
ENV WEB_DOCUMENT_ROOT=/app

# Crear todas las carpetas de almacenamiento necesarias (según documentación de Grow CRM)
RUN mkdir -p /app/updates \
    && mkdir -p /app/storage/avatars \
    && mkdir -p /app/storage/logos/clients \
    && mkdir -p /app/storage/logos/app \
    && mkdir -p /app/storage/files \
    && mkdir -p /app/storage/temp \
    && mkdir -p /app/application/storage/app/public \
    && mkdir -p /app/application/storage/cache/data \
    && mkdir -p /app/application/storage/debugbar \
    && mkdir -p /app/application/storage/logs \
    && mkdir -p /app/application/storage/temp \
    && mkdir -p /app/application/storage/framework/cache/data \
    && mkdir -p /app/application/storage/framework/sessions \
    && mkdir -p /app/application/storage/framework/testing \
    && mkdir -p /app/application/storage/framework/views \
    && mkdir -p /app/application/bootstrap/cache \
    && mkdir -p /app/application/storage/app/purifier/HTML

# Configurar permisos escribibles según documentación (775 es un buen balance)
# Carpetas que deben ser escribibles según Grow CRM
RUN chmod -R 775 /app/updates \
    && chmod -R 775 /app/storage \
    && chmod -R 775 /app/application/storage \
    && chmod -R 775 /app/application/bootstrap/cache \
    && chown -R application:application /app

# Asegurar que .env sea escribible si existe
RUN if [ -f /app/application/.env ]; then chmod 775 /app/application/.env; fi

# Establecer el directorio de trabajo
WORKDIR /app/application

# Regenerar autoload optimizado automáticamente
RUN composer dump-autoload --optimize --no-scripts

# Expone el puerto 80
EXPOSE 80

# NOTA: La imagen base webdevops/php-nginx se encarga automáticamente de:
# - Iniciar Nginx y PHP-FPM
# - Configurar permisos al inicio
# - Gestionar el proceso supervisor
