# Use the official PHP image from Docker Hub
FROM php:7.4-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zlib1g-dev libzip-dev zip unzip && docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd pdo pdo_mysql zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory
WORKDIR /var/www/html

# Copy Laravel application files into the container
COPY . .

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache


RUN mkdir -p /var/www/html/storage/logs
RUN chown -R www-data:www-data /var/www/html/storage/logs
RUN chmod -R 777 /var/www/html/storage/logs



# Install PHP dependencies
# RUN composer install

# Expose port 9000 for PHP-FPM (already done in the base image)

# Start the PHP-FPM service (already done in the base image)
