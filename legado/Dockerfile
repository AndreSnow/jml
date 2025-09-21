FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y libzip-dev zip unzip \
    && docker-php-ext-install mysqli pdo pdo_mysql

COPY . /var/www/html/

EXPOSE 80
