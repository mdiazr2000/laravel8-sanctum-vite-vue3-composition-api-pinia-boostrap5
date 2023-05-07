# laravel8-sanctum-vite-vue3-composition-api-pinia-boostrap5
Project created using Laravel 8 Vue3 with Vite, Composition Api and Pinia

# For backend
Run
composer install

Configure Database Detail
open .env and update database detail

DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<DATABASE NAME>
DB_USERNAME=<DATABASE USERNAME>
DB_PASSWORD=<DATABASE PASSWORD>

php artisan migrate:fresh --seed

php artisan serve

# For frontend
Run
npm install

Go to .env
Set the url of the api
VITE_APP_BACKEND_URL=http://localhost:8000/api
VITE_APP_SERVER_URL=http://localhost:8000

Run
npm run dev
