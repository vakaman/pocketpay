#!/usr/bin/env bash

APP_PATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 || exit ; pwd -P )" && cd "$APP_PATH"/../ || exit
pocketpayfolder=$PWD/pocket-manager
dockercompose="2-pocket-manager.yml"
containerapi=pocketpay-manager-api

show()
{
    project="Pocket Manager"
    message=$1
    type=$2
    reset="\\033[0m \n"

    if [ "$type" = "fail" ]; then
        color='\u001b[31m'
    elif [ "$type" = "warning" ]; then
        color='\u001b[33m'
    else
        color='\e[92m'
    fi

    printf "%b - %b %b %b" "$project" "$color" "$message" "$reset"
}

show "Create external networks..." "warning"
docker network create pocketpay-manager-external || true

show "Execute pre-build script..." "warning"
if ! docker run --rm -v "$pocketpayfolder":/app -w /app --user "$(id -u)":"$(id -g)" dumptec/php-fpm:dev-8.2-latest bash \
    -c "composer run-script post-root-package-install"; then
    show "ERROR: An error occurred while executing the pre-build script of the project" "fail"
    exit 1
fi

show "Deploying infrastructure using docker-compose..." "warning"
if ! docker-compose -f "$dockercompose" up -d --force-recreate --build ; then
    show "ERROR: An error occurred while uploading the project" "fail"
    exit 1
fi

show "Updating PHP dependencies..." "warning"
if ! docker-compose -f "$dockercompose" exec "$containerapi" composer install; then
    show "ERROR: An error occurred while updating the PHP packages" "fail"
    exit 1
fi

show "Configure cache..." "warning"
if ! docker-compose -f "$dockercompose" exec "$containerapi" php artisan config:clear ||
    ! docker-compose -f "$dockercompose" exec "$containerapi" php artisan config:cache; then
     show "ERROR: An error occurred while configure cache" "fail"
     exit 1
fi

show "Execute migrations and seeds..." "warning"
if ! docker-compose -f "$dockercompose" exec "$containerapi" php artisan migrate:fresh --seed --force; then
     show "ERROR: An error occurred while execute migrations" "fail"
     exit 1
fi

show "Update dependencies NPM..."
if ! docker-compose -f "$dockercompose" exec "$containerapi" npm install; then
    show "ERROR: An error occurred while updaTe NPM packages"
    exit 1
fi
