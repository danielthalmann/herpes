#!/bin/bash
set -euo pipefail

LOG_FILE=${LOG_FILE:="/app/storage/logs/entrypoint.log"}
WORKER=${WORKER:="false"}

main () {
    echo "Start main"

    composer_install
    npm_install
    init_environment
    db_migration
    optimize_app

    if [ "$WORKER" = "true" ]; then
        exec "$@"
    else
        wait_for_db
        run_server "$@"
    fi

}
init_environment() {
    echo "Init environment"

    if [ ! -f /app/.env ]; then
        cp /app/.env.exemple /app/.env
    fi

    if ! grep -qE '^APP_KEY=.+' /app/.env; then
        echo "APP_KEY empty"
        php artisan key:generate --force
    fi

    if [ ! -f /app/database/sqlite/database.sqlite ]; then
        touch /app/database/sqlite/database.sqlite
    fi

    # Ensure the symlink exists
    echo "php artisan storage:link"
    php artisan storage:link

}

prepare_storage() {
    echo "Create required directories for Laravel"
    mkdir -p /app/storage/framework/cache/data
    mkdir -p /app/storage/framework/sessions
    mkdir -p /app/storage/framework/views
    mkdir -p /app/storage/app/public
    mkdir -p /app/storage/logs
    mkdir -p /app/storage/pharmapro
    mkdir -p /app/database/sqlite
    mkdir -p /app/public/images
}

composer_install() {
    echo "composer install"
    composer install
}

npm_install() {
    echo "npm install"
    npm install
    echo "npm run build"
    npm run build
}

db_migration() {
    echo "php artisan migrate --force"
    php artisan migrate --force
}

optimize_app() {
    echo "Optimize app"
    echo "php artisan optimize:clear"
    php artisan optimize:clear
    echo "php artisan optimize"
    php artisan optimize
}

wait_for_db() {
    echo "Waiting for DB to be ready"
    until ./artisan migrate:status 2>&1 | grep -q -E "(Migration table not found|Migration name)"; do
        sleep 1
    done
}

run_server() {
    echo "Run server"
    exec /usr/local/bin/docker-php-entrypoint $@
}

prepare_storage

{
    main "$@"
} > "$LOG_FILE" 2>&1 | tee -a "$LOG_FILE"
