FROM composer:2 AS builder
WORKDIR /app

COPY composer.json composer.lock* /app/
RUN composer install --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs || \
    composer update --no-dev --prefer-dist --no-interaction --optimize-autoloader --no-scripts --ignore-platform-reqs

COPY . /app
RUN composer dump-autoload -o

FROM php:8.2-apache

ARG APACHE_RUN_PORT=8080
RUN apt-get update && apt-get install -y --no-install-recommends \
        git unzip libpng-dev libjpeg-dev libfreetype6-dev libonig-dev libzip-dev \
    && docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd \
    && rm -rf /var/lib/apt/lists/*

RUN sed -i "s/Listen 80/Listen ${APACHE_RUN_PORT}/g" /etc/apache2/ports.conf \
 && sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${APACHE_RUN_PORT}>/g" /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN echo "ServerName localhost" > /etc/apache2/conf-enabled/servername.conf

COPY --from=builder /app /var/www/html
RUN sed -i 's#/var/www/html#/var/www/html/public#g' /etc/apache2/sites-available/000-default.conf

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html
RUN chmod -R g=u /var/www/html

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENV PORT=${APACHE_RUN_PORT}
EXPOSE ${APACHE_RUN_PORT}

HEALTHCHECK --interval=30s --timeout=5s --start-period=10s --retries=3 \
  CMD curl -f http://127.0.0.1:${PORT}/ || exit 1

ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
CMD ["apache2-foreground"]
