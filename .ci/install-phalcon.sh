#!/usr/bin/env bash
#
# This file is part of the Phalcon Framework.
#
# (c) Phalcon Team <team@phalcon.io>
#
# For the full copyright and license information, please view the
# LICENSE.txt file that was distributed with this source code.

PHP_VERSION="$(php -r 'echo phpversion();' | cut -d '.' -f 1,2)"
PHALCON_VERSION=4.0.0-beta.2
PHALCON_BUILD=754
PHALCON_BRANCH=mainline
PHALCON_OS=ubuntu/xenial

PHALCON_REPO="https://packagecloud.io/phalcon/$PHALCON_BRANCH"
PHALCON_PKG="php$PHP_VERSION-phalcon_$PHALCON_VERSION-$PHALCON_BUILD+php${PHP_VERSION}_amd64.deb"

curl -sSL \
  "$PHALCON_REPO/packages/$PHALCON_OS/$PHALCON_PKG/download.deb" \
  -o /tmp/phalcon.deb \

mkdir /tmp/pkg
dpkg-deb -R /tmp/phalcon.deb /tmp/pkg
cp /tmp/pkg/usr/lib/php/*/phalcon.so "$(php-config  --extension-dir)/phalcon.so"
echo "extension=phalcon.so" > /etc/php/${PHP_VERSION}/cli/conf.d/50-phalcon.ini
