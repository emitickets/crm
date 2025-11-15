# Imagen base con PHP 8.2, Nginx, Node.js, gRPC y Supervisor
FROM gbetus/php-nginx-node-grpc:8.2

# Copiar archivos del proyecto (desde la raíz del proyecto)
# NOTA: Este Dockerfile debe ejecutarse desde la raíz con: docker build -f dockerizer/Dockerfile .
WORKDIR /app
COPY . /app

# Instalar dependencias de Composer
# La imagen base ya incluye Composer y las extensiones PHP necesarias
WORKDIR /app/application
RUN composer install --optimize-autoloader --no-interaction --no-dev

# Configurar Nginx para Laravel
# Este proyecto tiene index.php en la raíz, no en /public
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

# Crear archivos de configuración de supervisor para los cronjobs
# Supervisor ya está instalado en la imagen base y busca configuraciones en /opt/docker/etc/supervisor.d/
RUN mkdir -p /opt/docker/etc/supervisor.d

# Configuración de supervisor para el schedule principal de Laravel
RUN printf '[program:laravel-schedule]\n\
command=/bin/bash -c "while true; do /usr/local/bin/php /app/application/artisan schedule:run >> /dev/null 2>&1; sleep 60; done"\n\
autostart=true\n\
autorestart=true\n\
startretries=3\n\
user=root\n\
redirect_stderr=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n' > /opt/docker/etc/supervisor.d/laravel-schedule.conf

# Configuración de supervisor para el schedule de tenants
RUN printf '[program:laravel-tenants-schedule]\n\
command=/bin/bash -c "while true; do /usr/local/bin/php /app/application/artisan tenants:artisan schedule:run >> /dev/null 2>&1; sleep 60; done"\n\
autostart=true\n\
autorestart=true\n\
startretries=3\n\
user=root\n\
redirect_stderr=true\n\
stdout_logfile=/dev/stdout\n\
stdout_logfile_maxbytes=0\n' > /opt/docker/etc/supervisor.d/laravel-tenants-schedule.conf

# Expone el puerto 80
EXPOSE 80

# NOTA: La imagen base gbetus/php-nginx-node-grpc:8.2 incluye:
# - PHP 8.2, Nginx, Node.js y soporte para gRPC
# - Supervisor ya está instalado y configurado
# 
# NOTA: Los cronjobs están configurados con supervisor y se ejecutarán cada minuto:
# - schedule:run para el sistema principal (laravel-schedule)
# - tenants:artisan schedule:run para los tenants (laravel-tenants-schedule)
# 
# Los archivos de configuración de supervisor están en:
# - /opt/docker/etc/supervisor.d/laravel-schedule.conf
# - /opt/docker/etc/supervisor.d/laravel-tenants-schedule.conf
# 
# Supervisor se iniciará automáticamente con la imagen base
