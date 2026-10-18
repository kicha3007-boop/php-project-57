PORT ?= 8000

setup:
	composer install
	cp -n .env.example .env || true
	php artisan key:generate
	touch database/database.sqlite
	php artisan migrate --force --seed
	npm ci
	npm run build

start:
	php artisan serve --host 0.0.0.0 --port $(PORT)

.PHONY: setup start
