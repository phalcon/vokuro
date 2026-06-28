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

# Migrations are decoupled from container start - run them on demand with:
#   docker compose exec app composer migrate
#   docker compose exec app composer seed

# Hand off to the container command (the web server)
exec "$@"
