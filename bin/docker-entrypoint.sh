#!/usr/bin/env bash
set -euo pipefail

# Wait until the database accepts connections
bash bin/wait-for-db

# Ensure writable runtime cache/log directories exist
mkdir -p \
    var/cache/acl \
    var/cache/metaData \
    var/cache/session \
    var/cache/volt \
    var/logs

# Apply schema and seed data
vendor/bin/phinx migrate -c resources/phinx.php
vendor/bin/phinx seed:run -c resources/phinx.php || true

# Hand off to the container command (the web server)
exec "$@"
