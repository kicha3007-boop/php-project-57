FROM php:8.4-cli

RUN apt-get update && apt-get install -y libzip-dev libpq-dev git unzip curl \
    && docker-php-ext-install zip pdo pdo_pgsql \
    && curl -fsSL https://deb.nodesource.com/setup_22.x | bash - \
    && apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

RUN composer install --no-dev --optimize-autoloader && npm ci && npm run build

CMD ["bash", "-c", "php artisan migrate --force --seed && php artisan serve --host 0.0.0.0 --port $PORT"]
