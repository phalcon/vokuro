# docker build -t phalconphp/vokuro:4.0.5 -f resources/Dockerfile .

# debian/buster
FROM php:7.4-cli

ARG BUILD_ID=2
ARG VERSION=4.0.5

ENV BUILD_ID=$BUILD_ID \
    APP_VERSION=$VERSION \
    PHALCON_VERSION=4.0.5 \
    PHALCON_BUILD=923 \
    PHALCON_BRANCH=stable \
    PHALCON_OS=debian/buster

LABEL build_id="$BUILD_ID" \
      version="$VERSION" \
      vendor="Phalcon" \
      maintainer="Phalcon Team <team@phalcon.io>" \
      description="The PHP image to test Vökuró example concepts"

ADD . /code

WORKDIR /code

RUN export PHALCON_REPO="https://packagecloud.io/phalcon/$PHALCON_BRANCH" \
           PHALCON_PKG="php7.4-phalcon_$PHALCON_VERSION-$PHALCON_BUILD+php7.4_amd64.deb" \
    && curl -sSL \
        "$PHALCON_REPO/packages/$PHALCON_OS/$PHALCON_PKG/download.deb" \
        -o /tmp/phalcon.deb \
    && mkdir /tmp/pkg \
    && dpkg-deb -R /tmp/phalcon.deb /tmp/pkg \
    && cp /tmp/pkg/usr/lib/php/*/phalcon.so "$(php-config  --extension-dir)/phalcon.so" \
    && docker-php-ext-install opcache pdo_mysql mysqli 1> /dev/null \
    && printf "\\n" | pecl install --force psr 1> /dev/null \
    && echo "extension=psr.so" > "$PHP_INI_DIR/conf.d/docker-php-ext-psr.ini" \
    && echo "extension=phalcon.so" > "$PHP_INI_DIR/conf.d/docker-php-ext-phalcon.ini" \
    && php -m | grep -i "opcache\|mysql\|phalcon\|psr\|pdo\|mbstring" \
    && mv /code/.env.example /code/.env \
    && apt-get autoremove -y \
    && apt-get autoclean -y \
    && apt-get clean -y \
    && rm -rf /tmp/* /var/tmp/* \
    && find /var/cache/apt/archives /var/lib/apt/lists /var/cache \
       -not -name lock \
       -type f \
       -delete \
    && find /var/log -type f | while read f; do echo -n '' > ${f}; done

EXPOSE 80

# docker run -p 80:80 phalconphp/vokuro:4.0.5
CMD ["php", "-S", "0.0.0.0:80", "-t", "public/", ".htrouter.php"]
