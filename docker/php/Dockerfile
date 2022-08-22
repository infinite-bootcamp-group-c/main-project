FROM php:8.1-fpm

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc \
    && echo 'alias symfony="php bin/console"' >> ~/.bashrc


RUN apt install bash

WORKDIR /var/www/main

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -sS https://get.symfony.com/cli/installer | bash

COPY composer.* symfony.* ./