# Installation

The recommended way to run Vökuró is the Docker stack described in the
[README](../README.md). This document covers a local (non-Docker) setup.

## Requirements

* PHP 8.1 – 8.5 with the extensions: `openssl`, `mbstring`, `intl`, `pdo_mysql`
* MySQL 8.0 (or SQLite / PostgreSQL - see `DB_ADAPTER` in `.env`)
* [Composer](https://getcomposer.org/)

## 1. Install the Phalcon extension (v5)

Use [PIE](https://github.com/php/pie), the official PHP extension installer. Unlike
pecl, it builds the extension from source and supports PHP 8.5:

```bash
curl -fsSL https://github.com/php/pie/releases/latest/download/pie.phar -o pie.phar
sudo php pie.phar install phalcon/cphalcon:^5.0
php -m | grep -i phalcon
```

> To run on **v6** instead, skip this step and require the package:
> `composer require phalcon/phalcon:^6.0@alpha`.

## 2. Install dependencies

```bash
composer install
```

## 3. Configure the environment

```bash
cp .env.example .env
```

Edit `.env` and point the database at your host (the Docker defaults use the
`mysql` service name):

```dotenv
DB_HOST=127.0.0.1
```

## 4. Create and seed the database

```bash
composer migrate
composer seed
```

## 5. Serve the application

```bash
php -S localhost:8080 -t public .htrouter.php
```

Open <http://localhost:8080> and log in with a seeded account, e.g.
`sarah.connor@skynet.dev` / `password1`.

## Quality and tests

```bash
composer cs          # coding standard (PSR-12)
composer analyze     # static analysis (run without the v5 extension loaded)
composer cs-fixer    # PHP CS Fixer (dry-run)
composer test-unit
composer test-functional
composer test-acceptance
```
