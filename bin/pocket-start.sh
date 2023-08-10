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


show "Pull docker images..." "warning"
docker-compose \
    -f 1-pocket-pay.yml \
    -f 2-pocket-manager.yml \
    -f 3-pocket-notifyer.yml \
    pull

show "Create external networks..." "warning"
docker network create pocketpay-external || true
docker network create pocket-manager-external || true
docker network create pocket-notifyer-external || true

show "Up Pocket Pay" "warning"
bash bin/pocket-pay.sh