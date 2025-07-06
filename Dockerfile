FROM php:8.1-apache

# Install system dependencies for Composer
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy full app source (including vendor + composer.json if present)
COPY ./app/ /var/www/html/

# Install Composer and PHP dependencies
RUN curl -sS https://getcomposer.org/installer | php \
  && php composer.phar install \
  && rm composer.phar

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/uploads

# Expose Apache
EXPOSE 80
