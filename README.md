# Vökuró

[![Discord](https://img.shields.io/discord/310910488152375297?label=Discord)](https://phalcon.io/discord)
[![Phalcon Backers](https://img.shields.io/badge/phalcon-backers-99ddc0.svg)](https://github.com/phalcon/cphalcon/blob/master/BACKERS.md)

Vökuró is the sample application for the [Phalcon Framework](https://github.com/phalcon/cphalcon).
It showcases authentication, ACL-based permissions, user/profile management, forms,
mailing and more.

It runs on **Phalcon v5** (the C extension, default) and on **Phalcon v6**
(the `phalcon/phalcon` package, currently alpha) from the same source.

## Requirements

* PHP 8.1 – 8.5
* MySQL 8.0 (provided by the Docker stack)
* Docker + Docker Compose (recommended), or a local PHP with the Phalcon extension
  (see [docs/installation.md](docs/installation.md))

## Quick start (Docker)

```bash
cp .env.example .env
docker compose up -d --build
```

Then open:

* Application: <http://localhost:8080>
* Mailpit (captured e-mails): <http://localhost:8025>

The container waits for MySQL, runs the migrations and seeds, then serves the app.
Log in with one of the seeded accounts, e.g. `sarah.connor@skynet.dev` / `password1`.

### Choosing the Phalcon version

```bash
docker compose up -d --build                      # v5 (C extension, default)
PHALCON_VARIANT=v6 docker compose up -d --build   # v6 (phalcon/phalcon, alpha)
```

The two are mutually exclusive: the v5 image installs the C extension, the v6 image
installs the pure-PHP package instead.

## Composer scripts

Run them inside the container, e.g. `docker compose exec app composer cs`:

| Script | Description |
| --- | --- |
| `composer cs` | PHP_CodeSniffer (PSR-12) |
| `composer cs-fix` | Auto-fix coding standard issues (phpcbf) |
| `composer cs-fixer` | PHP CS Fixer (dry-run) |
| `composer cs-fixer-fix` | Apply PHP CS Fixer |
| `composer analyze` | PHPStan static analysis |
| `composer test-unit` | Unit test suite |
| `composer test-functional` | Functional test suite |
| `composer test-acceptance` | Acceptance test suite |
| `composer test` | All Codeception suites |
| `composer migrate` | Run database migrations (Phinx) |
| `composer seed` | Seed the database |

> `composer analyze` resolves Phalcon classes from the `phalcon/phalcon` (v6) source,
> so run it where the v5 C extension is **not** loaded (the CI `quality` job, or a plain
> host). The coding-standard and test scripts are unaffected.

## Updating Phalcon

* **v5** — bump `PHALCON_V5_CONSTRAINT` in `resources/docker/Dockerfile` and rebuild:
  `docker compose build app`. PIE compiles the C extension from source (this is the only
  way to update a C extension).
* **v6** — `docker compose exec app composer update phalcon/phalcon` (no rebuild).
  Dependabot opens the bump PR automatically.

## Project layout

Follows the [PDS skeleton](https://github.com/php-pds/skeleton):

```
bin/        executables (docker entrypoint, wait-for-db)
config/     application configuration
design/     static HTML snapshot of every screen (for design work)
docs/       documentation
public/     web server root
resources/  tooling configs, docker, phinx, migrations, seeds, codeception
src/        application source
tests/      Codeception suites
themes/     Volt views
var/        runtime cache and logs
```

## License

Vökuró is open-sourced software licensed under the New BSD License.
