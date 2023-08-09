#!/usr/bin/env bash

red=$(tput setaf 1)
green=$(tput setaf 2)
reset=$(tput sgr0)

echo "Removendo todos os containers, volumes e imagens desse projeto..."
cd ..
if docker-compose down --volumes --remove-orphans; then
    echo "${green}OK!${reset}"
else
    echo "${red}ERROR: Ocorreu um erro ao limpar os dados docker compose do projeto ${reset}"
fi
