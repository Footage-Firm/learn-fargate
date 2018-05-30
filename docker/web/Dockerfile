FROM node:8 as frontend
WORKDIR /app
COPY package.json package.json
RUN yarn
COPY ./resources ./resources
COPY ./webpack.mix.js .
RUN yarn run production

FROM videoblocks/alpine-laravel:latest

# base composer deps
COPY composer.json .
COPY composer.lock .
RUN composer install --no-progress --no-dev --no-autoloader

# source code
COPY . .

# autoloader
RUN composer install --no-progress --no-dev -o

# configs
RUN cp .env.production .env

# permissions for laravel
RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache

COPY --from=frontend /app/public/css public/css
COPY --from=frontend /app/public/js public/js

# Configure Laravel
RUN php artisan view:clear
RUN php artisan key:generate
RUN php artisan route:cache
RUN php artisan config:cache