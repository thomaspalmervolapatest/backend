#!/bin/sh

cd /var/www

# Wait for mysql to be up
if [ -n "$DB_HOST" ]; then
  /var/www/docker/wait-for-it.sh "$DB_HOST:${DB_PORT:-6000}" --timeout=120
fi

php artisan key:generate
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan route:cache
php artisan passport:keys
php artisan passport:client --password --no-interaction

/usr/bin/supervisord -c /etc/supervisord.conf
