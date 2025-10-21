#!/bin/bash
set -e

# Generate .env from environment variables if not exists
if [ ! -f /var/www/html/.env ]; then
  echo "Generating .env file from environment variables..."
  env | grep -E '^(APP_|DB_|MAIL_|REDIS_|CACHE_|QUEUE_)' > /var/www/html/.env
fi

# Jangan paksa chown kalau tidak punya izin
if [ -w /var/www/html/.env ]; then
  chown www-data:www-data /var/www/html/.env || true
else
  echo "Skip chown: insufficient permission on .env"
fi

# Laravel permissions (writeable dirs)
if [ -w /var/www/html/storage ]; then
  chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache || true
fi

# Jalankan migrasi otomatis opsional
# php artisan migrate --force || true

exec "$@"
