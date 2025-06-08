#!/bin/bash
set -e

# Installer les dépendances PHP si manquantes
if [ ! -f "vendor/autoload.php" ]; then
    echo "Running composer install..."
    composer install
fi

# Créer la DB SQLite si besoin
if [ ! -f "database/database.sqlite" ]; then
    echo "Creating SQLite database file..."
    touch database/database.sqlite
fi

# Fixer les permissions
chmod -R 775 storage bootstrap/cache database
chown -R www-data:www-data .

# Générer la clé
php artisan key:generate

# Migrations + seeds
php artisan migrate --seed

# Lancer Laravel
php artisan serve --host=0.0.0.0 --port=8000
