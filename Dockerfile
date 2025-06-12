# Étape 1 : Backend PHP + Node.js
FROM php:8.2-fpm

# Installer dépendances système et Node.js
RUN apt-get update && apt-get install -y \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    sqlite3 \
    libsqlite3-dev \
    npm \
    nodejs \
    && apt-get clean

# Installer extensions PHP
RUN docker-php-ext-install pdo pdo_sqlite

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Créer le dossier de travail
WORKDIR /var/www/html

# Copier tous les fichiers
COPY . .

ADD .env.example .env
 
# Installer dépendances PHP
RUN composer install

# Installer dépendances Node (frontend Vite)
RUN npm install

# Créer fichier DB SQLite
RUN mkdir -p database && touch database/database.sqlite

# Fixer les permissions nécessaires à Laravel
RUN chmod -R 775 storage bootstrap/cache database \
    && chown -R www-data:www-data .

# Exposer les ports Laravel + Vite
EXPOSE 8000 5173

# Lancer à la fois Laravel backend ET Vite frontend
CMD bash -c "php artisan key:generate && php artisan migrate --seed && php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"
