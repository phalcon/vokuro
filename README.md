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
cp resources/.env.example .env
docker compose up -d --build

# Create and seed the database (migrations are not run on boot)
docker compose exec app composer migrate
docker compose exec app composer seed
```

> **Note:** `app` is the Compose *service* name, used as-is by `docker compose exec` above. The
> running container, however, is named `${PROJECT_PREFIX}-app` - `vokuro-app` by default, set via
> `PROJECT_PREFIX` in `.env`. If you address it with plain `docker exec`, type your container name
> instead, e.g. `docker exec vokuro-app composer migrate` (substitute your own prefix).

Then open:

* Application: <http://localhost:8080>
* Mailpit (captured e-mails): <http://localhost:8025>

The container waits for MySQL and serves the app; migrations are decoupled from boot - apply them with the commands above.
Log in with one of the seeded accounts, e.g. `sarah.connor@skynet.dev` / `password1`.

### Choosing the Phalcon version

```bash
docker compose up -d --build                      # v5 (C extension, default)
PHALCON_VARIANT=v6 docker compose up -d --build   # v6 (phalcon/phalcon, alpha)
```

The two are mutually exclusive: the v5 image installs the C extension, the v6 image
installs the pure-PHP package instead.

### Choosing the PHP version

The image is built for one PHP version at a time, selected with the `PHP_VERSION`
build arg (default `8.5`; supported `8.1`–`8.5`):

```bash
docker compose up -d --build                  # PHP 8.5 (default)
PHP_VERSION=8.1 docker compose up -d --build  # PHP 8.1
PHP_VERSION=8.2 docker compose up -d --build  # PHP 8.2
PHP_VERSION=8.3 docker compose up -d --build  # PHP 8.3
PHP_VERSION=8.4 docker compose up -d --build  # PHP 8.4
```

PIE compiles the Phalcon C extension (and pcov) from source for the selected version.
The container keeps the same name (`vokuro-app`), so each rebuild **replaces** the
previous one. To run several versions side by side, give each its own Compose project
and prefix:

```bash
PHP_VERSION=8.1 PROJECT_PREFIX=vokuro81 docker compose -p vokuro81 up -d --build
# then: docker exec -w /srv vokuro81-app composer test
```

## Composer scripts

Run them inside the container, e.g. `docker compose exec app composer cs`:

| Script | Description |
| --- | --- |
| `composer cs` | PHP_CodeSniffer (PSR-12) |
| `composer cs-fix` | Auto-fix coding standard issues (phpcbf) |
| `composer cs-fixer` | PHP CS Fixer (dry-run) |
| `composer cs-fixer-fix` | Apply PHP CS Fixer |
| `composer analyze` | PHPStan static analysis |
| `composer test` | PHPUnit suites (unit + functional) |
| `composer test-coverage` | PHPUnit + Clover coverage (`tests/_output/coverage.xml`) |
| `composer migrate` | Run database migrations (Phinx) |
| `composer seed` | Seed the database |

> `composer analyze` resolves Phalcon classes from the `phalcon/phalcon` (v6) source,
> so run it where the v5 C extension is **not** loaded (the CI `quality` job, or a plain
> host). The coding-standard and test scripts are unaffected.

## Updating Phalcon

* **v5** - bump `PHALCON_V5_CONSTRAINT` in `resources/docker/Dockerfile` and rebuild:
  `docker compose build app`. PIE compiles the C extension from source (this is the only
  way to update a C extension).
* **v6** - `docker compose exec app composer update phalcon/phalcon` (no rebuild).
  Dependabot opens the bump PR automatically.

## Project layout

Follows the [PDS skeleton](https://github.com/php-pds/skeleton):

```
config/     application configuration
docs/       documentation
public/     web server root
resources/  tooling configs, docker, phinx, migrations, seeds
src/        application source
tests/      PHPUnit suites (unit, functional)
themes/     Volt views
var/        runtime cache and logs
```

## License

Vökuró is open-sourced software licensed under the New BSD License.
