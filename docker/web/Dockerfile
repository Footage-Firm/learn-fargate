FROM videoblocks/alpine-laravel:latest

# Copy in the files from the builder
COPY . /var/www/html

# Install yarn
#RUN apk --no-cache add yarn

# Install dependencies
#RUN composer install
#RUN yarn
#RUN yarn run production
#RUN cp .env.local .env

# Save space
#RUN rm -rf node_modules
#RUN apk del yarn

# Set file permissions
RUN chmod -R 777 storage && chmod -R 777 bootstrap/cache

# Configure Laravel
RUN php artisan view:clear
RUN php artisan key:generate
RUN php artisan route:cache
RUN php artisan config:cache