#!/bin/bash

set -e

cd "$(dirname "$0")"

echo "Running fresh migrations..."
php artisan migrate:fresh

echo "Seeding database..."
php artisan db:seed

echo "Done."
