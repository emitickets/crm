# Usa una imagen base de PHP con Apache
FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    nodejs \
    npm \
    && docker-php-ext-install pdo_mysql zip mbstring exif pcntl bcmath gd

# Habilita módulos de Apache
RUN a2enmod rewrite

# Copia el código fuente de Grow CRM (asegúrate de tener acceso legal al código)
COPY . /var/www/html/

# Instala Composer (si se requiere)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Instala dependencias de Composer en la ruta application
WORKDIR /var/www/html/application
RUN composer install --no-dev --optimize-autoloader
RUN npm install

# Configura permisos
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 775 /var/www/html/

# Expone el puerto 80
EXPOSE 80