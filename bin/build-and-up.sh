#!/usr/bin/env bash

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

APP_PATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 || exit ; pwd -P )" && cd "$APP_PATH"/../ || exit

show "Loading .env..." "warning"

set -a
. ./.env
set +a


show "Update docker images..." "warning"
docker-compose pull

show "Execute pre-build script..." "warning"
if ! docker run --rm -v "$PWD":/app -w /app --user "$(id -u)":"$(id -g)" dumptec/php-fpm:dev-8.2-latest bash \
    -c "composer run-script post-root-package-install"; then
    show "ERROR: An error occurred while executing the pre-build script of the project" "fail"
    exit 1
fi

show "Deploying infrastructure using docker-compose..." "warning"
if ! docker-compose up -d --force-recreate --build --remove-orphans; then
    show "ERROR: An error occurred while uploading the project" "fail"
    exit 1
fi

show "Updating PHP dependencies..." "warning"
if ! docker-compose exec phpfpm composer install; then
    show "ERROR: An error occurred while updating the PHP packages" "fail"
    exit 1
fi

show "Verificando chave do projeto..." "warning"
if ! docker-compose exec phpfpm php artisan app_key:exist; then
    show "Gerando chave do projeto..." "warning"
    if ! docker-compose exec phpfpm php artisan key:generate --ansi; then
        show "ERROR: Ocorreu ao gerar chave do projeto" "fail"
        exit 1
    fi
    show "Chave do projeto gerada!"
fi

show "Configurando cache..." "warning"
if ! docker-compose exec phpfpm php artisan config:clear ||
    ! docker-compose exec phpfpm php artisan config:cache; then
     show "ERROR: Ocorreu um erro ao configurar o cache" "fail"
     exit 1
fi

show "Executando migrations e seeds..." "warning"
if ! docker-compose exec phpfpm php artisan migrate:fresh --seed --force; then
     show "ERROR: Ocorreu um erro ao executar as migrations" "fail"
     exit 1
fi

# show "Atualizando dependências NPM..."
# if ! docker-compose exec phpfpm npm install; then
#         show "ERROR: Ocorreu um erro ao atualizar os pacotes NPM"
#         exit 1
# fi

# show "Compilando e publicando assets..."
# if ! docker-compose exec phpfpm npm run dev; then
#         show "ERROR: Ocorreu um erro ao atualizar os pacotes NPM"
#         exit 1
# fi

# show "Executando scripts pós build..."
# if ! docker-compose exec phpfpm bash -c "composer run-script post-build"; then
#      show "ERROR: Ocorreu um erro ao executar o script pós build."
#      exit 1
# fi

# printf "\n \n${yellow}Build concluída e servidor up"
# printf "Webserver: https://${APP_DOMAIN} \n"
# printf "Mailhog: http://${APP_DOMAIN}:${MAILHOG_WEB_PORT} \n"
# printf "PostgresSQL: ${APP_DOMAIN}:${DB_PORT} \n"
# printf "Redis: tcp://${APP_DOMAIN}:${REDIS_PORT} \n"
# printf "Redis Admin: http://${APP_DOMAIN}:${REDISADMIN_WEB_PORT} \n"

# exit 0
