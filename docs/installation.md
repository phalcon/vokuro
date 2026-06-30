# Installation

## Quick start (Docker)

Everything runs in Docker - you need **nothing** on your host except Docker itself
(no PHP, no extensions, no database). From the project root:

```bash
cp resources/.env.example .env
docker compose up -d --build

# Create and seed the database (not run on boot)
docker compose exec app composer migrate
docker compose exec app composer seed
```

Open <http://localhost:8080> and log in with a seeded account, e.g.
`sarah.connor@skynet.dev` / `password1`. E-mails are captured by Mailpit at
<http://localhost:8025>.

To run on a specific PHP version (default `8.5`, supported `8.1`–`8.5`):

```bash
PHP_VERSION=8.1 docker compose up -d --build   # or 8.2 / 8.3 / 8.4 / 8.5
```

The [README](../README.md) covers the rest of the Docker options (Phalcon v5/v6,
custom ports, running several PHP versions side by side).

## Local (non-Docker) setup

Prefer to run Vökuró directly on your host? Follow the steps below instead.

### Requirements

* PHP 8.1 – 8.5 with the extensions: `openssl`, `mbstring`, `intl`, `pdo_mysql`
* MySQL 8.0 (or SQLite / PostgreSQL - see `DB_ADAPTER` in `.env`)
* [Composer](https://getcomposer.org/)

### 1. Install the Phalcon extension (v5)

Use [PIE](https://github.com/php/pie), the official PHP extension installer. Unlike
pecl, it builds the extension from source and supports PHP 8.5:

```bash
curl -fsSL https://github.com/php/pie/releases/latest/download/pie.phar -o pie.phar
sudo php pie.phar install phalcon/cphalcon:^5.0
php -m | grep -i phalcon
```

> To run on **v6** instead, skip this step and require the package:
> `composer require phalcon/phalcon:^6.0@alpha`.

### 2. Install dependencies

```bash
composer install
```

### 3. Configure the environment

```bash
cp resources/.env.example .env
```

Edit `.env` and point the database at your host (the Docker defaults use the
`mysql` service name):

```dotenv
DB_HOST=127.0.0.1
```

### 4. Create and seed the database

```bash
composer migrate
composer seed
```

### 5. Serve the application

```bash
php -S localhost:8080 -t public .htrouter.php
```

Open <http://localhost:8080> and log in with a seeded account, e.g.
`sarah.connor@skynet.dev` / `password1`.

## Quality and tests

```bash
composer cs            # coding standard (PSR-12)
composer analyze       # static analysis (run without the v5 extension loaded)
composer cs-fixer      # PHP CS Fixer (dry-run)
composer test          # PHPUnit suites (unit, functional, browser)
composer test-coverage # PHPUnit + Clover coverage (tests/_output/coverage.xml)
```
