# docker build -t phalcon/vokuro ../

# debian/buster
FROM php:7.3-cli

ARG BUILD_ID=1
ARG VERSION=4.0.0

ENV BUILD_ID=$BUILD_ID \
    APP_VERSION=$VERSION \
    PHALCON_VERSION=4.0.0-beta.2 \
    PHALCON_BUILD=754 \
    PHALCON_BRANCH=mainline \
    PHALCON_OS=debian/buster

LABEL build_id="$BUILD_ID" \
      version="$VERSION" \
      vendor="Phalcon" \
      maintainer="Phalcon Team <team@phalcon.io>" \
      description="The PHP image to test Vökuró example concepts"

ADD .. /code

RUN export PHALCON_REPO="https://packagecloud.io/phalcon/$PHALCON_BRANCH" \
           PHALCON_PKG="php7.3-phalcon_$PHALCON_VERSION-$PHALCON_BUILD+php7.3_amd64.deb" \
    && curl -sSL \
        "$PHALCON_REPO/packages/$PHALCON_OS/$PHALCON_PKG/download.deb" \
        -o /tmp/phalcon.deb \
    && mkdir /tmp/pkg \
    && dpkg-deb -R /tmp/phalcon.deb /tmp/pkg \
    && cp /tmp/pkg/usr/lib/php/*/phalcon.so "$(php-config  --extension-dir)/phalcon.so"

WORKDIR /code

RUN docker-php-ext-install opcache pdo_mysql mysqli 1> /dev/null \
    && printf "\\n" | pecl install --force psr 1> /dev/null \
    && echo "extension=psr.so" > "$PHP_INI_DIR/conf.d/docker-php-ext-psr.ini" \
    && echo "extension=phalcon.so" > "$PHP_INI_DIR/conf.d/docker-php-ext-phalcon.ini" \
    && php -m | grep -i "opcache\|mysql\|phalcon\|psr\|pdo\|mbstring" \
    && unset PHALCON_REPO PHALCON_PKG \
    && apt-get autoremove -y \
    && apt-get clean -y \
    && rm -rf /tmp/* /var/tmp/* \
    && find /var/cache/apt/archives /var/lib/apt/lists /var/cache \
       -not -name lock \
       -type f \
       -delete \
    && find /var/log -type f | while read f; do echo -n '' > ${f}; done

EXPOSE 80

# docker run -p 80:80 phalcon/vokuro
CMD ["php", "-S", "0.0.0.0:80", "-t", "public/", ".htrouter.php"]
