# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ [запуск в данной директории docker] docker-compose -f docker-compose-8000.yml up -d --build
- $ [запуск в данной директории docker] sh .bash/docker-down.sh
- $ [запуск в корне проекта /projects/project1] docker-compose -p <PROJECT FOLDER NAME> -f ../../docker-compose.yml --env-file .env.docker.local up -d --build

## PHP (APACHE), NODAJS, NPM (gulp, grunt, bower, electron-forge)
- docker exec -it web-server-apache-<PROJECT-NAME> bash
- docker exec -it web-wordpress-<PROJECT-NAME> bash
- http://localhost:80XX/ - php или wordpress
- http://localhost:80XX/ - wordpress

## SERVICES
- http://localhost:51XX/ - web-phpmyadmin
- http://localhost:52XX/ - web-adminer
- http://localhost:53XX/ - web-pgadmin

## TODO
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */
- Загрузка актуальной БД
- Общая БД для справок фрон
