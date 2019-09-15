#!/usr/bin/env bash
#
# This file is part of the Phalcon Framework.
#
# (c) Phalcon Team <team@phalcon.io>
#
# For the full copyright and license information, please view the
# LICENSE.txt file that was distributed with this source code.

set -e

# Ensure that this is being run inside a CI container
if [ "${CI}" != "true" ]
then
  (>&2 echo "This script is designed to run inside a CI container only.")
  (>&2 echo "Aborting.")
  exit 1
fi

# 1. Shut down 9.* PostgreSQL database
# 2. Install PostgreSQL 11.*
# 3. Copy the authentication information from the old 9.6 configuration
# 4. Create a role called "travis"
sudo apt-get update
sudo apt-get --yes remove postgresql\* 1> /dev/null
sudo apt-get install -y postgresql-11 postgresql-client-11 1> /dev/null
sudo cp /etc/postgresql/{9.6,11}/main/pg_hba.conf
sudo service postgresql restart 11

psql -c 'CREATE ROLE travis SUPERUSER LOGIN CREATEDB;' -U postgres
psql --version
