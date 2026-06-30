# Vökuró

[![Latest Version][packagist-version-badge]][packagist-version-link]
[![PHP Version][php-version-badge]][packagist-version-link]
[![Total Downloads][packagist-downloads-badge]][packagist-downloads-link]
[![License][license-badge]][license-link]

[![Vokuro CI][vokuro-ci-badge]][vokuro-ci-link]
[![Quality Gate Status][sonar-quality-badge]][sonar-link]
[![Coverage][sonar-coverage-badge]][sonar-link]
[![PDS Skeleton][pds-skeleton-badge]][pds-skeleton-link]

[![Discord][discord-badge]][discord-link]
[![Contributors][contributors-badge]][contributors-link]
[![OpenCollective Backers][oc-backers-badge]][oc-backers-link]
[![OpenCollective Sponsors][oc-sponsors-badge]][oc-sponsors-link]

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
| `composer test` | PHPUnit suites (unit, functional, browser) |
| `composer test-coverage` | PHPUnit + Clover coverage (`tests/_output/coverage.xml`) |
| `composer migrate` | Run database migrations (Phinx) |
| `composer seed` | Seed the database |

> `composer analyze` resolves Phalcon classes from the `phalcon/phalcon` (v6) source,
> so run it where the v5 C extension is **not** loaded (the CI `quality` job, or a plain
> host). The coding-standard and test scripts are unaffected.

## Running the tests

The suite is split into three PHPUnit testsuites - `unit`, `functional`, and `browser`
(in-process browser testing through [`phalcon/talon`](https://github.com/phalcon/talon)).
The Docker stack provides everything they need: a seeded MySQL database and a
[Mailpit](https://mailpit.axllent.org/) SMTP catcher, so no e-mail ever leaves the host.

```bash
docker compose up -d --build
docker compose exec app composer migrate          # once - create the schema
docker compose exec app composer seed             # once - load fixtures

docker compose exec app composer test             # the full suite
docker compose exec app composer test-coverage    # + Clover coverage in tests/_output
```

### Test secrets

The test configuration lives in `tests/.env.test` and is loaded automatically by
`tests/bootstrap.php` - you do not need to supply anything by hand:

| Variable | Value | Purpose |
| --- | --- | --- |
| `APP_CRYPT_SALT` | *(preset)* | crypt key for the session / security services |
| `DB_USERNAME` / `DB_PASSWORD` | `root` / `secret` | matches the MySQL container's root password |
| `DB_NAME` | `vokuro` | the migrated and seeded test database |
| `MAIL_SMTP_SERVER` / `MAIL_SMTP_PORT` | `127.0.0.1` / `1025` | Mailpit catcher - tests never reach a real SMTP server |

Real OS / CI environment variables take precedence over `tests/.env.test`, so the same
suite runs unchanged inside Docker (service-name hosts `mysql` / `mailpit`) and on a
native host or in CI (loopback `127.0.0.1`). The only secret that is **not** local is
`SONAR_TOKEN`, a GitHub Actions secret used solely by the `sonarqube` job.

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
tests/      PHPUnit suites (unit, functional, browser)
themes/     Volt views
var/        runtime cache and logs
```

## License

Vökuró is open-sourced software licensed under the New BSD License. See [LICENSE](LICENSE).

<!-- Badges -->
[packagist-version-badge]:   https://img.shields.io/packagist/v/phalcon/vokuro?include_prereleases&style=flat-square&logo=packagist&logoColor=white
[packagist-version-link]:    https://packagist.org/packages/phalcon/vokuro
[packagist-downloads-badge]: https://img.shields.io/packagist/dt/phalcon/vokuro?style=flat-square&logo=packagist&logoColor=white
[packagist-downloads-link]:  https://packagist.org/packages/phalcon/vokuro/stats
[php-version-badge]:         https://img.shields.io/packagist/php-v/phalcon/vokuro?style=flat-square&logo=php&logoColor=white
[license-badge]:             https://img.shields.io/github/license/phalcon/vokuro?style=flat-square&logo=opensourceinitiative&logoColor=white
[license-link]:              https://github.com/phalcon/vokuro/blob/master/LICENSE
[vokuro-ci-badge]:           https://github.com/phalcon/vokuro/actions/workflows/main.yml/badge.svg?branch=master
[vokuro-ci-link]:            https://github.com/phalcon/vokuro/actions/workflows/main.yml
[sonar-quality-badge]:       https://sonarcloud.io/api/project_badges/measure?project=phalcon_vokuro&metric=alert_status
[sonar-coverage-badge]:      https://sonarcloud.io/api/project_badges/measure?project=phalcon_vokuro&metric=coverage
[sonar-link]:                https://sonarcloud.io/summary/new_code?id=phalcon_vokuro
[pds-skeleton-badge]:        https://img.shields.io/badge/pds-skeleton-blue.svg?style=flat-square
[pds-skeleton-link]:         https://github.com/php-pds/skeleton
[discord-badge]:             https://img.shields.io/discord/310910488152375297?label=Discord&logo=discord&style=flat-square
[discord-link]:              https://phalcon.io/discord
[contributors-badge]:        https://img.shields.io/github/contributors/phalcon/vokuro?style=flat-square&logo=github&logoColor=white
[contributors-link]:         https://github.com/phalcon/vokuro/graphs/contributors
[oc-backers-badge]:          https://img.shields.io/opencollective/backers/phalcon?style=flat-square&logo=opencollective&logoColor=white
[oc-backers-link]:           https://opencollective.com/phalcon
[oc-sponsors-badge]:         https://img.shields.io/opencollective/sponsors/phalcon?style=flat-square&logo=opencollective&logoColor=white
[oc-sponsors-link]:          https://opencollective.com/phalcon
