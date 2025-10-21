#!/bin/bash
set -e

echo "Generating .env file from environment variables..."

# Pastikan direktori ada
mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Buat .env hanya jika belum ada
if [ ! -f /var/www/html/.env ]; then
  echo "Creating .env file..."
  {
    # Ambil semua variabel yang diawali APP_ atau DB_ dari Jenkins
    env | grep -E '^(APP_|DB_|CACHE_|QUEUE_|MAIL_|REDIS_)' || true
  } > /var/www/html/.env
else
  echo ".env already exists, skipping generation."
fi

# Jangan ubah ownership atau permission — OpenShift tidak izinkan
# Jalankan Apache
exec "$@"
