# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ [запуск в корне проекта] docker-compose -f ../../docker-compose.yml --env-file .env.docker.local up -d --build
- $ [запуск в данной директории] docker-compose --env-file projects/<PROJECT FOLDER NAME>/.env.docker.local up -d
- $ [запуск в данной директории] sh .bash/docker-down.sh

## PHP (APACHE)
- docker exec -it web-server-apache bash
- http://localhost:80XX/ - php

- docker exec -it web-wordpress bash
- http://localhost:90XX/ - wordpress

## NODAJS, NPM (gulp, grunt, bower, electron-forge)
- docker exec -it nodejs bash

## SERVICES
- http://localhost:51XX/ - web-phpmyadmin
- http://localhost:52XX/ - web-adminer
- http://localhost:53XX/ - web-pgadmin

## TODO
- Опрокинуть права в контейнер
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */
- Общаяя  БД
- Загрузка актуальной БД