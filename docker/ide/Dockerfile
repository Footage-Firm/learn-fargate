# https://hub.docker.com/_/php/
FROM php:7.1
RUN pecl install xdebug-2.6.0 \
    && docker-php-ext-enable xdebug

RUN apt-get update \
    && apt-get install -y libmagickwand-dev \
    && rm -rf /var/lib/apt/lists/*

RUN pecl install imagick \
    && docker-php-ext-enable imagick

