# Use official PHP image
FROM php:8.2-fpm

# Nginx o'rnatish
RUN apt-get update && apt-get install -y nginx

# Install dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pdo_pgsql

# Set working directory
WORKDIR /var/www/laravel-test-1

# Laravel uchun kerakli ruxsatlarni o'rnatish
RUN chown -R www-data:www-data /var/www/laravel-test-1
RUN #chmod -R 775 /var/www/laravel-test-1/storage
RUN #chmod -R 775 /var/www/laravel-test-1/bootstrap/cache

# Nginx konfiguratsiyasini kiritish
COPY laravel-test-1.conf /etc/nginx/sites-available/default

# Portni ochish
EXPOSE 80

# Nginx va PHP-FPMni ishga tushirish
CMD ["sh", "-c", "service nginx start && php-fpm"]
