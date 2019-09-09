#!/usr/bin/env bash
#
# This file is part of the Phalcon Framework.
#
# (c) Phalcon Team <team@phalcon.io>
#
# For the full copyright and license information, please view the
# LICENSE.txt file that was distributed with this source code.

set -e

: "${DB_NAME:=vokuro}"

case "$DB_ADAPTER" in
  "mysql")
    cmd="CREATE DATABASE IF NOT EXISTS $DB_NAME CHARSET=utf8 COLLATE=utf8_unicode_ci;"
    echo "running command '$cmd'"
    mysql -e "$cmd"
    ;;
  "pgsql")
    cmd="create database $DB_NAME;"
    echo "running command '$cmd'"
    psql -c "$cmd" -U postgres
    ;;
  *)
    ;;
esac
