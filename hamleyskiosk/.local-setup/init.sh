#!/bin/bash

if ! [ -x "$(command -v git)" ]; then
  echo 'Error: git is not installed.' >&2
  exit 1
fi


#Args
POSITIONAL=()
LARADOCK_EXISTS_IGNORE=0

while [[ $# -gt 0 ]]; do
    key="$1"

    case $key in
        -f|--force-reinstall)
        LARADOCK_EXISTS_IGNORE=1
        shift
        ;;
        *)
        POSITIONAL+=("$1")
        shift
        ;;
    esac
done

#Look around
if [[ -d 'laradock' ]]; then
    if [[ $LARADOCK_EXISTS_IGNORE -lt 1 ]]; then
        echo "Laradock folder already exists. Looks like it has been installed!"
        echo "To force reinstall run this script again with the -f flag"
        exit 1
    else
        rm -Rf ./laradock
    fi;
fi;

#Laradock
git clone -b master --single-branch https://github.com/laradock/laradock.git \
	&& cp ./.local-setup/laradock-env ./laradock/.env \
	&& cp ./.local-setup/.env_app ./.env

# Ignore submodule updates
git config submodule.laradock.active false

#Build workspace without cache
cd laradock \
  && docker-compose build --no-cache workspace php-fpm mariadb nginx

# docker-compose exec workspace  bash -c 'composer install && npm install && npm run dev && php artisan migrate && php artisan key:generate'

cd ..
# echo "Done! Run './.local-setup/start.sh' to get going. Remember to check the README for further instructions"




# npm install
# npm run dev
# php artisan migrate
# php artisan key:generate
