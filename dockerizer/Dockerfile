# --- Etapa 1: Builder ---
# Esta etapa instala dependencias de PHP, Node.js y compila los assets frontend

FROM php:8.2-cli-alpine AS builder

# Instalar dependencias del sistema (git, zip, nodejs, npm)
# Incluir Python 3 y herramientas de compilación para node-sass
RUN apk add --no-cache \
    git \
    zip \
    unzip \
    python3 \
    make \
    g++ \
    curl \
    bash \
    libzip-dev \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    freetype-dev \
    libjpeg-turbo-dev

# Instalar Node.js 14 usando nvm (compatible con node-sass 4.14.1)
ENV NVM_VERSION=0.39.0
ENV NODE_VERSION=14.21.3
ENV NVM_DIR=/root/.nvm
ENV PATH="$NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH"

RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v${NVM_VERSION}/install.sh | bash \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install ${NODE_VERSION} \
    && nvm alias default ${NODE_VERSION} \
    && nvm use default

# Instalar extensiones de PHP necesarias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        zip \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copiar archivos del proyecto (desde la raíz del proyecto)
# NOTA: Este Dockerfile debe ejecutarse desde la raíz con: docker build -f dockerizer/Dockerfile .
WORKDIR /app
COPY . /app

# Instalar dependencias de Composer (sin dev para producción)
WORKDIR /app/application
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Instalar dependencias de Node y compilar assets
# Configurar Python para node-gyp (node-sass lo requiere)
ENV PYTHON=/usr/bin/python3
RUN npm install --legacy-peer-deps && npm run production

# --- Etapa 2: Production ---
# Esta etapa usa la imagen de webdevops y copia los archivos compilados

FROM webdevops/php-nginx:8.2

# Copiar los archivos de la aplicación desde el builder
COPY --from=builder /app /app

# Configurar Nginx para Laravel (root debe apuntar a /app/public)
# La imagen base webdevops/php-nginx usa variables de entorno para configurar el vhost
ENV WEB_DOCUMENT_ROOT=/app/public

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

# Ejecutar scripts de Composer post-install (si es necesario)
RUN composer dump-autoload --optimize

# Expone el puerto 80
EXPOSE 80

# NOTA: La imagen base webdevops/php-nginx se encarga automáticamente de:
# - Iniciar Nginx y PHP-FPM
# - Configurar permisos al inicio
# - Gestionar el proceso supervisor
