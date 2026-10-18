PORT ?= 8000

setup: install env db build

install:
	composer install
	npm ci

env:
	[ -f .env ] || cp .env.example .env
	php artisan key:generate --force

db:
	touch database/database.sqlite
	php artisan migrate --force --seed

build:
	npm run build

start:
	php artisan serve --host 0.0.0.0 --port $(PORT)

lint:
	composer exec --verbose phpcs -- --standard=PSR12 app routes tests database

lint-fix:
	composer exec --verbose phpcbf -- --standard=PSR12 app routes tests database

test:
	php artisan test

.PHONY: setup install env db build start lint lint-fix test
