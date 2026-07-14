#!/bin/bash


LOG_FILE=/app/storage/logs/entrypoint.log

main () {

    composer_install
    init_environment
    db_migration

    if [ "$WORKER" = "true" ]; then
        optimize_app
        exec "$@"
    else
        wait_for_db
        run_server "$@"
    fi

}
init_environment() {

    if [ ! -f /app/.env ]; then
        cp /app/.env.exemple /app/.env
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
    # Create required directories for Laravel
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

db_migration() {
    echo "php artisan migrate --force"
    php artisan migrate --force
}

optimize_app() {
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
    /usr/local/bin/docker-php-entrypoint $@
}

prepare_storage

{
    main "$@"
} > "$LOG_FILE" 2>&1
