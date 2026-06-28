# syntax=docker/dockerfile:1
ARG PHP_VERSION=8.5

FROM php:${PHP_VERSION}-cli AS base

ARG PHP_VERSION=8.5
ARG PHALCON_VARIANT=v5
ARG PHALCON_V5_CONSTRAINT="^5.0"
ARG UID=1000
ARG GID=1000
ARG USER=vokuro
ARG GROUP=vokuro

# System packages, PHP extensions and an unprivileged user matching the host UID
RUN <<EOT
set -eux
groupadd -g "${GID}" "${GROUP}"
useradd -l -m -u "${UID}" -g "${GID}" -s /bin/bash "${USER}"
apt-get update -y
apt-get install -yq --no-install-recommends \
    curl \
    default-mysql-client \
    git \
    libicu-dev \
    libzip-dev \
    unzip \
    zip
docker-php-ext-install intl pdo_mysql zip
apt-get clean -y
rm -rf /var/lib/apt/lists/*
EOT

# Composer
COPY --from=composer/composer:2 /usr/bin/composer /usr/bin/composer

# Phalcon provider, selected at build time (v5 = C extension via PIE, v6 = composer package).
# PIE (php/pie) replaces pecl; it builds the extension from the Packagist source, so it is not
# bound by pecl's stale "<= 8.4.99" release metadata, and it auto-enables the extension.
RUN <<EOT
set -eux
if [ "${PHALCON_VARIANT}" = "v5" ]; then
    apt-get update -y
    apt-get install -yq --no-install-recommends ${PHPIZE_DEPS}
    curl -fsSL https://github.com/php/pie/releases/latest/download/pie.phar -o /usr/local/bin/pie
    chmod +x /usr/local/bin/pie
    pie install --no-interaction phalcon/cphalcon:${PHALCON_V5_CONSTRAINT}
    php -m | grep -i phalcon
    apt-get clean -y
    rm -rf /var/lib/apt/lists/*
fi
EOT

COPY resources/docker/extra.ini /usr/local/etc/php/conf.d/zz-vokuro.ini
COPY --chown=${UID}:${GID} resources/docker/.bashrc /home/${USER}/.bashrc

# Writable HOME / Composer home for the unprivileged user. Docker does not reliably set HOME
# on a USER switch, and we never use /tmp; keep the cache in the user's home (outside /srv).
ENV HOME=/home/${USER} \
    COMPOSER_HOME=/home/${USER}/.composer

# Create /srv owned by the unprivileged user so `composer install` can write vendor/
RUN install -d -m 0775 -o "${USER}" -g "${GROUP}" /srv

WORKDIR /srv
COPY --chown=${UID}:${GID} . /srv

USER ${USER}

# Install dependencies. Phalcon is provided by:
#  - v5: the C extension installed above (the phalcon/phalcon dev package stays dormant)
#  - v6: the phalcon/phalcon package (a dev dependency) since no extension is installed
RUN composer install --prefer-dist --no-interaction --no-progress

EXPOSE 8080

ENTRYPOINT ["bash", "bin/docker-entrypoint.sh"]
CMD ["php", "-S", "0.0.0.0:8080", "-t", "public", ".htrouter.php"]
