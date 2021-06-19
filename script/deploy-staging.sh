#!/bin/bash

# Usage: ./script/deploy-staging.sh
# Script to deploy staging environment

git pull origin main
composer install
yarn install
yarn production
php artisan migrate:fresh --seed --force
