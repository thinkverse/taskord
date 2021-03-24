#!/bin/bash

git pull origin main
composer install --no-progress
composer dump-autoload
yarn install
yarn prod
php artisan app:clean
