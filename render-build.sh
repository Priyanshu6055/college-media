#!/usr/bin/env bash
set -eux

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Generate Application Key
php artisan key:generate

# Run migrations
php artisan migrate --force

# Clear and cache configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
