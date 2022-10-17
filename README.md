# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ docker-compose --env-file projects/<PROJECT FOLDER NAME>/.env.docker.local up -d
- $ sh .bash/docker-down.sh

## PHP (APACHE)
- docker exec -it web-server-apache bash
- http://localhost:8000/ - php

- docker exec -it web-wordpress bash
- http://localhost:9000/ - wordpress

## NODAJS, NPM (gulp, grunt, bower, electron-forge)
- docker exec -it nodejs bash

## SERVICES
- http://localhost:5001/ - web-phpmyadmin
- http://localhost:5002/ - web-adminer
- http://localhost:5003/ - web-pgadmin

## TODO
- Опрокинуть права в контейнер
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */