FROM composer:2 AS builder

WORKDIR /app

COPY composer.json composer.lock* /app/
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs || \
    composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY . /app
RUN composer dump-autoload -o

# ---- PHP runtime ----
FROM php:8.2-apache

ARG APACHE_RUN_PORT=8080

RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev curl \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Konfigurasi Apache
RUN sed -i "s/Listen 80/Listen ${APACHE_RUN_PORT}/g" /etc/apache2/ports.conf \
 && sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${APACHE_RUN_PORT}>/g" /etc/apache2/sites-available/000-default.conf \
 && sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf \
 && a2enmod rewrite

# Copy hasil build
COPY --from=builder /app /var/www/html

# Permission fix (OpenShift friendly)
RUN chown -R www-data:0 /var/www/html && chmod -R g+rwX /var/www/html
RUN chmod -R g+rwX /var/www/html \
 && chmod -R g+rwX /var/www/html/storage /var/www/html/bootstrap/cache \
 && find /var/www/html -type d -exec chmod g+s {} \;

# Copy entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose port
ENV PORT=${APACHE_RUN_PORT}
EXPOSE ${APACHE_RUN_PORT}

# Jalankan sebagai non-root agar sesuai OpenShift
USER 1001

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
  CMD curl -f http://127.0.0.1:${PORT}/ || exit 1

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
