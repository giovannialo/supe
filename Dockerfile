FROM php:8.1.7-apache

# Atualiza pacotes
RUN apt-get update

# Instala unzip
RUN apt-get install -y unzip

# Instala a extensão PDO
RUN docker-php-ext-install pdo pdo_mysql

# Instala o módulo rewrite
RUN a2enmod rewrite

# Instala o composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer