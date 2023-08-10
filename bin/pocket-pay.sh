#!/usr/bin/env bash

APP_PATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 || exit ; pwd -P )" && cd "$APP_PATH"/../ || exit
pocketpayfolder=$PWD/pocket-pay
dockercompose="1-pocket-pay.yml"
containerapi=pocketpay-api

show()
{
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

    printf "%b %b %b" "$color" "$message" "$reset"
}


show "Execute pre-build script..." "warning"
if ! docker run --rm -v "$pocketpayfolder":/app -w /app --user "$(id -u)":"$(id -g)" dumptec/php-fpm:dev-8.2-latest bash \
    -c "composer run-script post-root-package-install"; then
    show "ERROR: An error occurred while executing the pre-build script of the project" "fail"
    exit 1
fi

show "Deploying infrastructure using docker-compose..." "warning"
if ! docker-compose -f "$dockercompose" up -d --force-recreate --build --remove-orphans ; then
    show "ERROR: An error occurred while uploading the project" "fail"
    exit 1
fi

show "Updating PHP dependencies..." "warning"
if ! docker-compose -f "$dockercompose" exec "$containerapi" composer install; then
    show "ERROR: An error occurred while updating the PHP packages" "fail"
    exit 1
fi

# show "Verificando chave do projeto..." "warning"
# if ! docker-compose exec phpfpm php artisan app_key:exist; then
#     show "Gerando chave do projeto..." "warning"
#     if ! docker-compose exec phpfpm php artisan key:generate --ansi; then
#         show "ERROR: Ocorreu ao gerar chave do projeto" "fail"
#         exit 1
#     fi
#     show "Chave do projeto gerada!"
# fi

show "Configure cache..." "warning"
if ! docker-compose -f "$dockercompose" exec "$containerapi" php artisan config:clear ||
    ! docker-compose exec "$containerapi" php artisan config:cache; then
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

show "Compile and publish assets..."
if ! docker-compose -f "$dockercompose" exec "$containerapi" npm run dev; then
    show "ERROR: An error occurred while compile and publish assets"
    exit 1
fi

# # show "Executando scripts pós build..."
# # if ! docker-compose exec phpfpm bash -c "composer run-script post-build"; then
# #      show "ERROR: Ocorreu um erro ao executar o script pós build."
# #      exit 1
# # fi

show "\n \n Build finish and server up"
show "Webserver: https://${APP_DOMAIN} \n"
show "Mailhog: http://${APP_DOMAIN}:${MAILHOG_WEB_PORT} \n"
show "PostgresSQL: ${APP_DOMAIN}:${DB_PORT} \n"
show "Redis: tcp://${APP_DOMAIN}:${REDIS_PORT} \n"
show "Redis Admin: http://${APP_DOMAIN}:${REDISADMIN_WEB_PORT} \n"

