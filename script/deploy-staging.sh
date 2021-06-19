#!/bin/bash

# Usage: ./script/deploy-staging.sh
# Script to deploy staging environment

composer install
yarn install
yarn production
cp .env.example .env
php artisan key:generate
mysql -u root -e "DROP DATABASE taskord; CREATE DATABASE taskord;"
php artisan migrate
php artisan db:seed
php artisan test
cd ../
rm -rf taskord
