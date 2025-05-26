FROM php:8.2-apache

# Install dependencies and intl extension
RUN apt-get update && apt-get install -y \
    libicu-dev \
    && docker-php-ext-install intl mysqli pdo pdo_mysql

RUN apt-get update && apt-get install -y default-mysql-client

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy all project files to the container
COPY . /var/www/html/

# Overwrite config file: rename local-local-php to local.php
COPY ./config/autoload/local-local.php /var/www/html/config/autoload/local.php
RUN rm -f /var/www/html/config/autoload/local-local.php
RUN rm -f /var/www/html/config/autoload/local.php.dist

# Set working directory
WORKDIR /var/www/html
