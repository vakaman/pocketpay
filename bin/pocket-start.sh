#!/usr/bin/env bash

show()
{
    project="Pocket Start"
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

APP_PATH="$( cd -- "$(dirname "$0")" >/dev/null 2>&1 || exit ; pwd -P )" && cd "$APP_PATH"/../ || exit

show "Create required .env..." "warning"
cp .env.example .env
cp pocket-pay/.env.example pocket-pay/.env
cp pocket-notifyer/.env.example pocket-notifyer/.env
cp pocket-manager/.env.example pocket-manager/.env

show "Loading .env..." "warning"

set -a
. ./.env
set +a

show "Create external networks..." "warning"
docker network create pocketpay-manager-external || true
docker network create pocketpay-notifyer-external || true
docker network create pocketpay-external || true

show "Pull docker images..." "warning"
docker-compose \
    -f 1-pocket-pay.yml \
    -f 2-pocket-manager.yml \
    -f 3-pocket-notifyer.yml \
    pull

## Pocket Pay is a web system that has provides a fryendly interface to user
show "Up Pocket Pay" "warning"
if ! bash bin/pocket-pay.sh ; then
    show "ERROR: An error occurred while Up Pocket Pay" "fail"
    exit 1
fi
show "Pocket Pay was sucefully up"

## Pocket Manager is an API to process and manage users funds
show "Up Pocket Manager" "warning"
if ! bash bin/pocket-manager.sh; then
    show "ERROR: An error occurred while Up Pocket Manager" "fail"
    exit 1
fi
show "Pocket Manager was sucefully up"

## Pocket Notifyer is an API to process messages that needs to be send to users
show "Up Pocket Notifyer" "warning"
if ! bash bin/pocket-notifyer.sh; then
    show "ERROR: An error occurred while Up Pocket Notifyer" "fail"
    exit 1
fi
show "Pocket Notifyer was sucefully up"
