# docker build -t phalconphp/vokuro:4.1.2 -f docker/Dockerfile .

# debian/buster
FROM php:7.4-cli

ENV VERSION=4.1.2

LABEL version="$VERSION" \
      vendor="Phalcon" \
      maintainer="Phalcon Team <team@phalcon.io>" \
      description="The PHP image to test Vökuró example concepts"

ADD . /code

WORKDIR /code

RUN apt update \
    && curl -s https://packagecloud.io/install/repositories/phalcon/stable/script.deb.sh | bash \
    && apt update -y \
    && apt install php7.4-phalcon \
    && docker-php-ext-install opcache pdo_mysql mysqli 1> /dev/null \
    && printf "\\n" | pecl install --force psr 1> /dev/null \
    && docker-php-ext-enable psr \
    && docker-php-ext-enable phalcon \
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

# docker run -p 80:80 phalconphp/vokuro:4.1.2
CMD ["php", "-S", "0.0.0.0:80", "-t", "public/", ".htrouter.php"]
