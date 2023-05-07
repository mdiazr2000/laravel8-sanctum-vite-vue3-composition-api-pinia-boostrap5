Configure Database Detail

composer install 

open .env and update database detail

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DATABASE NAME>
DB_USERNAME=<DATABASE USERNAME>
DB_PASSWORD=<DATABASE PASSWORD>

php artisan migrate:fresh --seed

php artisan serve
