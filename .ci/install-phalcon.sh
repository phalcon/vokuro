#!/usr/bin/env bash
#
# This file is part of the Phalcon Framework.
#
# (c) Phalcon Team <team@phalcon.io>
#
# For the full copyright and license information, please view the
# LICENSE.txt file that was distributed with this source code.

set -e

: "${PHALCON_VERSION:=master}"

EXT_DIR="$(php-config --extension-dir)"
ASSETS="phalcon-$PHALCON_VERSION/php-$(php-config --vernum)/$(lscpu | grep Architecture | awk '{print $2}')"

# Using cache only for tagged Phalcon versions
if [[ -f "$HOME/assets/$ASSETS/phalcon.so" ]] && [[ "$PHALCON_VERSION" != "master" ]]
then
  cp "$HOME/assets/$ASSETS/phalcon.so" "$EXT_DIR/phalcon.so"
else
  git clone --depth=1 -v https://github.com/phalcon/cphalcon.git -b "$PHALCON_VERSION" /tmp/phalcon
  cd /tmp/phalcon/build || extit 1
  ./install --phpize "$(phpenv which phpize)" --php-config "$(phpenv which php-config)" 1> /dev/null

  mkdir -p "$HOME/assets/$ASSETS"
  cp "$EXT_DIR/phalcon.so" "$HOME/assets/$ASSETS/phalcon.so"
fi

echo extension=phalcon.so >> "$(phpenv prefix)/etc/php.ini"

"$(phpenv which php)" -m | grep -q phalcon
