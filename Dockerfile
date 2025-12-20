# --- Stage 1: Build PHP Dependencies (Composer) ---
FROM composer:lts AS deps
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

# --- Stage 2: Build Frontend Assets (Node.js/Vite) ---
FROM node:18-alpine AS nodejs
WORKDIR /app
COPY . .
# Install dependencies Node & Jalankan Build Vite
RUN npm install
RUN npm run build

# --- Stage 3: Final Production Image ---
FROM php:8.2-apache-bookworm

# 1. Install System Dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo_mysql zip bcmath

# 2. Config Apache
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 3. Copy Composer Binary
COPY --from=deps /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# 4. Copy Vendor (PHP Deps) dari Stage 1
COPY --from=deps /app/vendor ./vendor

# 5. Copy Frontend Build (CSS/JS) dari Stage 2 (PENTING!)
COPY --from=nodejs /app/public/build ./public/build

# 6. Copy Source Code Aplikasi
COPY . .

# 7. Set Permissions & Clean Up
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# 8. Final Autoload
RUN composer dump-autoload --optimize

EXPOSE 80
