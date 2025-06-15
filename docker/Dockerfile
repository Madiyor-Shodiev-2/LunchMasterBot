FROM php:8.2-alpine

RUN apk add --no-cache \
        libpng \
        libpng-dev \
        libzip-dev \
        oniguruma-dev \
        zip \
        curl \
        git \
    && docker-php-exit-install pdo pdo_mysql pdo_pgsql zip gd mbstring exif

COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-interaction

COPY . .

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    chown -R www-data:www-data /var/www/html

EXPOSE 9000

CMD ["php-fpm"]