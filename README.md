# DOCKER FOR ALL PROJECTS

## BASH DOCKER UP/DOWN
- $ docker-compose up -d --build (запустить localhost:8000 - список всех проектов)

## PHP (APACHE), NODAJS, NPM (gulp, grunt, bower, electron-forge)
- http://localhost:80XX/ - php или wordpress (в зависимости от образа)
- https://localhost:90XX/ - php или wordpress (в зависимости от образа)

## SERVICES
- http://localhost:51XX/ - web-phpmyadmin
- http://localhost:52XX/ - web-adminer
- http://localhost:53XX/ - web-pgadmin

## TODO
- Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */
- Загрузка актуальной БД
- Опрокинуть права в контейнер
- short open tag (php.ini)
- проблема с БД - давая логин и пароль для входа мы даем доступ к продакшину
-
