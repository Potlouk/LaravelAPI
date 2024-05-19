# Dockerfile for Laravel
FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    unzip \
    git \
    nginx \
    default-mysql-client \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libzip-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory contents
COPY . /var/www/html/

COPY ./default.conf /etc/nginx/sites-available/default

# Install dependencies
RUN composer install --no-interaction --no-scripts --no-suggest --optimize-autoloader
RUN php artisan key:generate
RUN chown -R www-data:www-data /var/www/html

CMD service nginx start && php-fpm