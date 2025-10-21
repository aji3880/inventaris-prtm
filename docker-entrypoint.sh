#!/bin/bash
set -e

# Pastikan folder yang dibutuhkan punya permission benar
if [ -d /var/www/html ]; then
  mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache
  chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache 2>/dev/null || true
fi

# Buat .env hanya jika belum ada
if [ ! -f /var/www/html/.env ]; then
  echo "Generating .env file from environment variables..."

  cat > /var/www/html/.env <<EOF
APP_NAME=${APP_NAME:-Laravel}
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY:-}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=${LOG_CHANNEL:-stack}

DB_CONNECTION=${DB_CONNECTION:-mysql}
DB_HOST=${DB_HOST:-mysql}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE:-inventory-app_db}
DB_USERNAME=${DB_USERNAME:-inventory-app_user}
DB_PASSWORD=${DB_PASSWORD:-pass123}

CACHE_DRIVER=${CACHE_DRIVER:-file}
QUEUE_CONNECTION=${QUEUE_CONNECTION:-sync}
SESSION_DRIVER=${SESSION_DRIVER:-file}
SESSION_LIFETIME=${SESSION_LIFETIME:-120}

EOF

  chown www-data:www-data /var/www/html/.env
fi

# Jalankan migrasi jika diminta
if [ "${RUN_MIGRATIONS}" = "true" ]; then
  echo "Running Laravel migrations..."
  php /var/www/html/artisan migrate --force || true
fi

# Eksekusi perintah CMD container (biasanya apache2-foreground)
exec "$@"
