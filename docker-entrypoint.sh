#!/bin/bash
set -e

if [ -d /var/www/html ]; then
  chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
  mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
fi

if [ ! -f /var/www/html/.env ] && [ -n "${APP_KEY}" ]; then
  echo "APP_KEY=${APP_KEY}" > /var/www/html/.env
fi

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php /var/www/html/artisan migrate --force || true
fi

exec "$@"
