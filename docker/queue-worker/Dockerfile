FROM videoblocks/alpine-laravel:latest

# Deps for pecl
RUN apk add --no-cache \
    php7-pear \
    php7-dev \
    gcc \
    musl-dev \
    libtool \
    make

# Install imagick deps
RUN apk add --no-cache imagemagick-dev

# Install and activate imagick
RUN pecl install imagick \
    && echo "extension=imagick.so" >> /etc/php7/php.ini