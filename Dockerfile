FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpq-dev \
    libonig-dev \
    zip unzip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql mbstring bcmath

RUN a2enmod rewrite
RUN a2dismod mpm_event || true
RUN a2enmod mpm_prefork

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN php -d memory_limit=-1 /usr/bin/composer install \
    --optimize-autoloader \
    --no-dev \
    --no-interaction \
    --prefer-dist

RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

RUN echo 'Listen ${PORT}' > /etc/apache2/ports.conf

RUN echo '<VirtualHost *:${PORT}>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

CMD php artisan config:cache && \
    php artisan migrate --force && \
    apache2-foreground
