# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ [запуск в корне проекта] docker-compose -p <PROJECT FOLDER NAME> -f ../../docker-compose.yml --env-file .env.docker.local up -d --build
- $ [запуск в данной директории] sh .bash/docker-down.sh

## PHP (APACHE), NODAJS, NPM (gulp, grunt, bower, electron-forge)
- docker exec -it web-server-apache-<PROJECT-NAME> bash
- http://localhost:80XX/ - php

- docker exec -it web-wordpress-<PROJECT-NAME> bash
- http://localhost:90XX/ - wordpress

## SERVICES
- http://localhost:51XX/ - web-phpmyadmin
- http://localhost:52XX/ - web-adminer
- http://localhost:53XX/ - web-pgadmin

## TODO
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */
- Загрузка актуальной БД
- Общая БД для справок фрон