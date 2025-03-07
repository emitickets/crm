FROM webdevops/php-nginx:8.2
# ENVIROMENTS
ENV NODE_VERSION=18.19.1
ENV NVM_DIR=/root/.nvm
ENV PATH="/root/.nvm/versions/node/v${NODE_VERSION}/bin/:${PATH}"

# Install NVM and Node.js
RUN curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.3/install.sh | bash \
    && . "$NVM_DIR/nvm.sh" \
    && nvm install ${NODE_VERSION} \
    && nvm alias default ${NODE_VERSION} \
    && nvm use default

# RUN mkdir -p /var/cache/nginx_cache && chown -R www-data:www-data /var/cache/nginx_cache

# Copia archivos de configuración desde dockerizer
COPY ./dockerizer/php.ini /opt/docker/etc/php/php.ini
COPY ./dockerizer/nginx.conf /etc/nginx/nginx.conf
COPY ./dockerizer/vhost.conf /opt/docker/etc/nginx/vhost.conf
COPY ./dockerizer/laravel.sh /app/laravel.sh 

# Copiar dependencias del proyecto
COPY ./application/package*.json /app/application
COPY ./application/composer.json ./application/composer.lock /app/application/

WORKDIR /app/application  
RUN composer install --no-interaction --no-scripts
RUN npm install
COPY . /app

# Ajusta permisos y propietario en /app
RUN chmod -R 755 /app/application/bootstrap/ \
    && chmod -R 755 /app/application/storage/ \
    && chmod -R 755 /app/application/public/ \
    && chown -R application:application /app/application/bootstrap/ \
    && chown -R application:application /app/application/storage/ \
    && chown -R application:application /app/application/ \
    && chmod +x /app/application/laravel.sh 
RUN /app/application/laravel.sh

# Expone el puerto 80
EXPOSE 80