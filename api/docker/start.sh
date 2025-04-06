#!/bin/sh

composer install --no-dev --optimize-autoloader

php artisan migrate --force

php artisan optimize:clear
php artisan optimize

php artisan storage:link

# Inicializar o supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisor.conf