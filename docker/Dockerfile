FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/laravel-test-1

RUN chown -R www-data:www-data /var/www \
    && chmod -R 775 /var/www

COPY laravel-test-1.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD ["sh", "-c", "nginx -g 'daemon off;' & php-fpm -F"]