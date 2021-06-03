#!/bin/bash

# Usage: ./script/ci.sh
# Script to run CI in Buildkite

composer install
yarn install
yarn production
cp .env.example .env
php artisan key:generate
mysql -uroot --execute="DROP DATABASE taskord; CREATE DATABASE taskord;"
php artisan migrate
php artisan db:seed
php artisan test
cd ../
rm -rf taskord
