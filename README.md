# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ [запуск в данной директории docker] docker-compose up -d --build
- $ [запуск в данной директории docker] sh .bash/docker-down.sh
# - $ [запуск в данной директории docker] docker-compose -p <PROJECT FOLDER NAME> --env-file projects/<PROJECT FOLDER NAME>/ .env.docker.local -f docker-compose-project.yml up -d --build

## PHP (APACHE), NODAJS, NPM (gulp, grunt, bower, electron-forge)
- docker exec -it web-server-<PROJECT-NAME> bash
- http://localhost:80XX/ - php или wordpress (в зависимости от образа)
- https://localhost:90XX/ - php или wordpress (в зависимости от образа)

## SERVICES
- http://localhost:51XX/ - web-phpmyadmin
- http://localhost:52XX/ - web-adminer
- http://localhost:53XX/ - web-pgadmin

## TODO
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */
- Загрузка актуальной БД
