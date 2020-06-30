sed -i "s/^DB_CONNECTION.*$/DB_CONNECTION=${DB_CONNECTION}/g" /app/.env
sed -i "s/^DB_HOST.*$/DB_HOST=${DB_HOST}/g" /app/.env
sed -i "s/^DB_DATABASE.*/DB_DATABASE=${DB_DATABASE}/g" /app/.env
sed -i "s/^DB_USERNAME.*/DB_USERNAME=${DB_USERNAME}/g" /app/.env
sed -i "s/^DB_PASSWORD.*/DB_PASSWORD=${DB_PASSWORD}/g" /app/.env
sed -i "s/^APP_NAME.*/APP_NAME=${APP_NAME}/g" /app/.env
php artisan key:generate
php artisan migrate
php artisan serve --host=0.0.0.0 --port=8181
