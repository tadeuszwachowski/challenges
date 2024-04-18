FROM php:apache

RUN docker-php-ext-install pdo_mysql mysqli

# Copy files into the container
COPY index.php /var/www/html/index.php
COPY flag.txt /var/www/html/flag.txt

EXPOSE 80
