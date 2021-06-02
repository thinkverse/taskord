#!/bin/bash

composer install
yarn install
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan test
