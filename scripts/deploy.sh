#!/bin/bash

git pull origin main
composer install --no-progress
composer dump-autoload
yarn install
yarn production
php artisan app:clean
