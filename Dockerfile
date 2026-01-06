# ============================================
# Stage 1: Dependencies
# ============================================
FROM php:8.4-fpm-alpine AS dependencies

# Install system dependencies
RUN apk add --no-cache \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    sqlite-dev \
    mysql-client \
    git \
    unzip

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_sqlite \
    zip \
    bcmath \
    intl \
    gd \
    mbstring

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install \
    --no-scripts \
    --no-autoloader \
    --prefer-dist \
    --optimize-autoloader

# ============================================
# Stage 2: Frontend Builder
# ============================================
FROM node:20-alpine AS builder

WORKDIR /var/www/html

# Copy package files
COPY package*.json ./
COPY vite.config.js ./
COPY postcss.config.js ./
COPY tailwind.config.js ./

# Install npm dependencies
RUN npm ci

# Copy source files needed for build
COPY resources ./resources
COPY public ./public

# Build assets
RUN npm run build

# ============================================
# Stage 3: Production
# ============================================
FROM php:8.4-fpm-alpine

# Install runtime dependencies only
RUN apk add --no-cache \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    icu-libs \
    oniguruma \
    sqlite-libs \
    mysql-client \
    bash

# Install PHP extensions (same as dependencies stage)
RUN apk add --no-cache --virtual .build-deps \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    sqlite-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
    pdo_mysql \
    pdo_sqlite \
    zip \
    bcmath \
    intl \
    gd \
    mbstring && \
    apk del .build-deps

# Set working directory
WORKDIR /var/www/html

# Copy vendor from dependencies stage
COPY --from=dependencies /var/www/html/vendor ./vendor

# Copy built assets from builder stage
COPY --from=builder /var/www/html/public/build ./public/build

# Copy application files
COPY . .

# Install Composer for autoloader generation
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy composer files and generate autoloader
COPY composer.json composer.lock ./
RUN composer dump-autoload --optimize

# Create necessary directories and set permissions
RUN mkdir -p storage/framework/{cache,sessions,views} \
    storage/logs \
    bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache

# Copy entrypoint script
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expose PHP-FPM port
EXPOSE 9000

# Use entrypoint for initialization
ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]

# Start PHP-FPM
CMD ["php-fpm"]
