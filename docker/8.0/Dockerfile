FROM composer:latest as composer
FROM php:8.0-fpm

# Set working directory
WORKDIR /code

LABEL vendor="Phalcon" \
      maintainer="Phalcon Team <team@phalcon.io>" \
      description="The PHP image to test the Vökuró example concepts"

ENV PHALCON_VERSION="5.0.0RC4" \
    PHP_VERSION="8.0"

# Update
RUN apt update -y && \
    apt install -y \
        apt-utils \
        gettext \
        git \
        libzip-dev \
        nano \
        sudo \
        wget \
        zip

# PECL Packages
RUN pecl install -o -f redis && \
    pecl install phalcon-${PHALCON_VERSION}  \
      xdebug

# Install PHP extensions
RUN docker-php-ext-install \
      gettext \
      pdo_mysql \
      zip

# Install PHP extensions
RUN docker-php-ext-enable \
      opcache \
      phalcon \
      redis \
      xdebug

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Add user
RUN groupadd -g 1000 phalcon
RUN useradd -u 1000 -ms /bin/bash -g phalcon phalcon

# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Copy existing application directory contents
COPY . /code

# Bash script with helper aliases
COPY ./config/.bashrc /root/.bashrc
COPY ./config/.bashrc /home/phalcon/.bashrc

# Copy existing application directory permissions
COPY --chown=phalcon:phalcon . /code

# Change current user to phalcon
USER phalcon

EXPOSE 80

CMD ["php", "-S", "0.0.0.0:80", "-t", "public/", ".htrouter.php"]
