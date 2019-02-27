FROM php:7.2-apache

RUN docker-php-ext-install mysqli 
WORKDIR /var/www/html/
COPY . .
COPY ./b7bot.sql /var/www/html/mysql-start/
