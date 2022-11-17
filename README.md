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
- Загрузка актуальной БД
- short open tag (php.ini)
- проблема с БД - давая логин и пароль для входа мы даем доступ к продакшину
- http://192.168.0.91:8003/ (зделать так что бы можно было смотреть сайты разработчиков с моего компа)
- Переименовать проект в Docker с большой буквы
- Отказаться от тестовых стендов (продумать как можно ссылку кидать на при локальной разработке на ветке)
- Проставлять cd путь для команд start stop restart другим т.к. на Windwos он будет другим cd ~/Desktop/docker/projects/project
