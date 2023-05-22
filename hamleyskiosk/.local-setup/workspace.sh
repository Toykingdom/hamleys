#!/bin/bash

if [ ! -d 'app' ]; then
    echo "Wrong call path, run it from site root!"
    exit 1
fi;

cd laradock

RUN_AS_ROOT=0


while [[ $# -gt 0 ]]; do
    key="$1"

    case $key in
        -r|--root)
        RUN_AS_ROOT=1
        shift
        ;;
    esac
done

if [[ $RUN_AS_ROOT -lt 1 ]]; then
  docker compose exec --user=laradock workspace bash
else
  docker compose exec workspace bash
fi
