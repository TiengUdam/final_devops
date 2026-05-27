FROM php:8.2-fpm

# ដំឡើង dependencies
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev \
    libxml2-dev libpq-dev zip unzip nginx \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# ដំឡើង PHP extensions សម្រាប់ PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring bcmath gd

# ដំឡើង Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files មុន
COPY composer.json composer.lock ./

# Install dependencies
RUN php -d memory_limit=-1 /usr/bin/composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist

# Copy files ទាំងអស់
COPY . .

# Run composer scripts
RUN php -d memory_limit=-1 /usr/bin/composer dump-autoload --optimize

# កំណត់ permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
RUN chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-available/default

EXPOSE 80

CMD php artisan config:cache && \
    php artisan migrate --force && \
    envsubst '$PORT' < /etc/nginx/sites-available/default > /etc/nginx/sites-enabled/default && \
    service nginx start && \
    php-fpm -F
