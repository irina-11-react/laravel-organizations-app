# Organization App

Laravel API for managing organizations and their relations (parent / sister / daughter).

## Requirements
- PHP 8.2+
- Composer

## Setup
```bash
git clone https://github.com/irina-11-react/laravel-organizations-app.git
cd laravel-organizations-app
composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
php artisan serve
