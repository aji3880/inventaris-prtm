#!/bin/bash
set -e

echo "Generating .env file from environment variables..."
cat <<EOF > /var/www/html/.env
APP_ENV=${APP_ENV}
APP_DEBUG=${APP_DEBUG}
APP_KEY=${APP_KEY}
DB_CONNECTION=${DB_CONNECTION}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}
EOF

chmod 666 /var/www/html/.env || true

if [ "${RUN_MIGRATIONS}" = "true" ]; then
  php /var/www/html/artisan migrate --force || true
fi

exec "$@"
