#!/bin/bash

cd laradock \
    && docker-compose up -d nginx workspace php-fpm mariadb
