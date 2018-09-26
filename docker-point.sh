sed -i "s/127.0.0.1/${MYSQL_HOST}/g" /app/.env
php artisan serve --host=0.0.0.0 --port=8181