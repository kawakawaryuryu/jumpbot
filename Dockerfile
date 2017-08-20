# php image
FROM php:latest

# Composer
FROM composer:latest

# change working directory for ADD instruction
WORKDIR /app

# copy files to /app directory
ADD . /app

# composer install
RUN composer install

# execute tweet
CMD php main.php
