#!/bin/bash

LOG_FILE=/app/storage/logs/entrypoint.log

main () {

    init_environment
    #composer_install
    if [ "$WORKER" = "true" ]; then
        optimize_app
        exec "$@"
    else
        app_deploy
        prepare_storage
        wait_for_db
        run_server "$@"
    fi

}
init_environment() {

    if [ ! -f /app/.env ]; then
        mv /app/.env.production /app/.env
        php artisan key:generate --force
    fi
    if [ ! -f /app/database/sqlite/database.sqlite ]; then
        touch /app/database/sqlite/database.sqlite
    fi

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
    touch /app/database/sqlite/database.sqlite
    mkdir -p /public/images

    # Ensure the symlink exists
    echo "php artisan storage:link"
    php artisan storage:link
}

composer_install() {
    echo "composer install"
    composer install
}

app_deploy() {
    echo "php artisan migrate --force"
    php artisan migrate --force
    echo "php artisan deploy"
    php artisan deploy
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

{
    main "$@"
} > "$LOG_FILE" 2>&1
