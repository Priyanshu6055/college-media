#!/usr/bin/env bash
set -eux

# Install Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer

# Install Laravel dependencies
composer install --no-dev --optimize-autoloader

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --force

# Cache Laravel configurations
php artisan config:cache
php artisan route:cache
php artisan view:cache
