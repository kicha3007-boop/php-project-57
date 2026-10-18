# Менеджер задач (PHP)

[![hexlet-check](https://github.com/kicha3007-boop/php-project-57/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/kicha3007-boop/php-project-57/actions/workflows/hexlet-check.yml)
[![PHP CI](https://github.com/kicha3007-boop/php-project-57/actions/workflows/workflow.yml/badge.svg)](https://github.com/kicha3007-boop/php-project-57/actions/workflows/workflow.yml)

Система управления задачами по мотивам Redmine: задачи со статусами, исполнителями и метками,
фильтр списка, регистрация и вход.

Стек: Laravel 13, Breeze (аутентификация), spatie/laravel-html (формы), spatie/laravel-query-builder (фильтр),
laracasts/flash, Tailwind CSS 4, Sentry SDK для коллектора ошибок (Bugsink/Sentry).

Демо: деплой на Render пока не выполнен.

## Требования

- PHP 8.4+, Composer
- Node.js 20+
- SQLite (по умолчанию) или PostgreSQL

## Установка и запуск

```bash
git clone https://github.com/kicha3007-boop/php-project-57.git
cd php-project-57
make setup     # зависимости, .env, ключ, миграции с сидами, сборка фронтенда
make start     # http://localhost:8000
```

База выбирается настройками окружения: по умолчанию SQLite (`database/database.sqlite`),
для PostgreSQL — `DB_CONNECTION=pgsql` и `DB_URL=postgresql://user:password@host:5432/db`
(или `DB_HOST`, `DB_DATABASE`, …). Коллектор ошибок — `SENTRY_LARAVEL_DSN`.

## Разработка

```bash
make lint   # PHP_CodeSniffer, PSR-12
make test   # PHPUnit
```
