# Imagen base con PHP 8.2, Nginx, Node.js, gRPC y Supervisor
FROM gbetus/php-nginx-node-grpc:8.2

# Copiar archivos del proyecto (desde la raíz del proyecto)
# NOTA: Este Dockerfile debe ejecutarse desde la raíz con: docker build -f dockerizer/Dockerfile .
WORKDIR /app
COPY . /app

# Instalar dependencias de Composer
# La imagen base ya incluye Composer y las extensiones PHP necesarias
WORKDIR /app/application
RUN composer install --optimize-autoloader --no-interaction 

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

# Copiar configuraciones de Supervisor para los cronjobs
# La imagen base gbetus/php-nginx-node-grpc:8.2 ya tiene Supervisor configurado
# y usa el directorio /opt/docker/etc/supervisor.d/ para configuraciones adicionales
COPY ./dockerizer/supervisor-laravel-schedule.conf /opt/docker/etc/supervisor.d/laravel-schedule.conf
COPY ./dockerizer/supervisor-laravel-tenants-schedule.conf /opt/docker/etc/supervisor.d/laravel-tenants-schedule.conf

# Configurar logs para Supervisor (Schedule)
RUN mkdir -p /var/log \
    && touch /var/log/laravel-schedule.log /var/log/laravel-schedule-error.log \
    && touch /var/log/laravel-tenants-schedule.log /var/log/laravel-tenants-schedule-error.log \
    && chown root:root /var/log/laravel-schedule.log /var/log/laravel-schedule-error.log \
    && chown root:root /var/log/laravel-tenants-schedule.log /var/log/laravel-tenants-schedule-error.log \
    && chmod 644 /var/log/laravel-schedule.log /var/log/laravel-schedule-error.log \
    && chmod 644 /var/log/laravel-tenants-schedule.log /var/log/laravel-tenants-schedule-error.log

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
# Los logs de supervisor están en:
# - /var/log/laravel-schedule.log
# - /var/log/laravel-schedule-error.log
# - /var/log/laravel-tenants-schedule.log
# - /var/log/laravel-tenants-schedule-error.log
# 
# Para verificar el estado de supervisor dentro del contenedor:
# - supervisorctl status
# - supervisorctl tail -f laravel-schedule
# - supervisorctl restart laravel-schedule
# 
# Supervisor se iniciará automáticamente con la imagen base
