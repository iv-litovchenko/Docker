<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Локальная разработка проектов</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style type="text/css">
    </style>
</head>
<body>

<?php
require('dotenv.php');

// $list = [];
// foreach (glob("*/") as $filename) {
//     $port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
//     $list[$port] = $filename;
// }
// ksort($list);

$list = file_get_contents('http://ilitovfa.beget.tech/docker-api/');
$list = json_decode($list, true);
#print $dockerContent;
#exit();

?>

<h2 align="center" style="margin-top: 100px;">Локальная разработка проектов</h2>

<table class="table table-bordered table-striped" style="width: 50%; margin: 0 auto; margin-bottom: 100px;">
    <thead>
    <tr>
        <th>#</th>
        <th>Порт</th>
        <th align="center">URL</th>
        <th>Проект</th>
        <th colspan="3">Сервисы</th>
        <th>GitLab</th>
        <th>Prod.Puth</th>
        <th>Adminka</th>
        <th>DB.Import</th>
        <th>Команды</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td colspan="12">
            <pre style="margin: 0; color: red;">При работе внутри контейнера нужно переключиться на пользователя "su www-data"
В PHP-приходит переменная "DOCKER_PROJECT_ENV: local", по ней мождно определить среду работы проекта на локали</pre>
        </td>
    </tr>
    <?php
    foreach ($list as $row) {
        #$port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
        #$project_name = (new dotenv(__DIR__ . '/' . $filename))->load('PROJECT_NAME');

        $vars = [];
        $vars['DOCKER_PROJECT_NAME'] = $row['DOCKER_PROJECT_NAME'];
        $vars['DOCKER_PROJECT_PUBLIC_PATH'] = $row['DOCKER_PROJECT_PUBLIC_PATH'];
        $vars['DOCKER_PROJECT_PHP_VERSION'] = $row['DOCKER_PROJECT_PHP_VERSION'];
        $vars['DOCKER_PROJECT_NODEJS_VERSION'] = $row['DOCKER_PROJECT_NODEJS_VERSION'];
        $vars['DOCKER_PROJECT_PORT'] = $row['DOCKER_PROJECT_PORT'];
        $vars['DOCKER_PROJECT_DB_NAME'] = $row['DOCKER_PROJECT_DB_NAME'];
        # $vars['DB_CHARSET'] = $row[''];
        # $vars['DB_COLLATE'] = $row[''];

        $commandList = [];
        $commandList[] = " cd ~/Desktop/docker/projects/".$row['DOCKER_PROJECT_NAME']." ";
        foreach($vars as $k => $v){
            $commandList[] = " export " . $k . "='" . $v . "' ";
        }

        // docker-compose -p <PROJECT FOLDER NAME> --env-file projects/<PROJECT FOLDER NAME>/ .env.docker.local -f docker-compose-project.yml up -d --build
        $commandList = implode(" && " , $commandList);
        $commandUp = $commandList . ' && docker-compose -p "'. $row['DOCKER_PROJECT_NAME'] .'" -f ../../docker-compose-project.yml up -d ';
        $commandDown = $commandList . ' && docker-compose -p "'. $row['DOCKER_PROJECT_NAME'] .'" -f docker-compose-project.yml down ';
        ?>
        <tr>
            <td style="background: <?php if (file_exists($row['DOCKER_PROJECT_NAME'] . '/')) { echo 'green'; } else { echo 'red'; } ?>">
                &nbsp;
            </td>
            <td>[X0<?= $row['DOCKER_PROJECT_PORT'] ?>]</td>
            <td nowrap>
                <a href="http://localhost:80<?= $row['DOCKER_PROJECT_PORT'] ?>/?t=<?= time(); ?>">http</a> |
                <a href="https://localhost:90<?= $row['DOCKER_PROJECT_PORT'] ?>/?t=<?= time(); ?>">https</a>
            </td>
            <td><?= $row['DOCKER_PROJECT_NAME']; ?></td>
            <td><a href="http://localhost:51<?= $row['DOCKER_PROJECT_PORT'] ?>">phpmyadmin</a></td>
            <td><a href="http://localhost:52<?= $row['DOCKER_PROJECT_PORT'] ?>">adminer</a></td>
            <td><a href="http://localhost:53<?= $row['DOCKER_PROJECT_PORT'] ?>">pgadmin</a></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td nowrap>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStart_<?=$row['id'];?>">
                    <span class="glyphicon glyphicon-play"></span> Start
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalStart_<?=$row['id'];?>" tabindex="-1" aria-labelledby="modalStartLabel_<?=$row['id'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalStartLabel_<?=$row['id'];?>">Поднять контейнер</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre><?=$commandUp;?></pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStop_<?=$row['id'];?>">
                    <span class="glyphicon glyphicon-play"></span> Stop
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalStop_<?=$row['id'];?>" tabindex="-1" aria-labelledby="modalStopLabel_<?=$row['id'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalStopLabel_<?=$row['id'];?>">Опустить контейнер</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre><?=$commandDown;?></pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDockerExec_<?=$row['id'];?>">
                    <span class="glyphicon glyphicon-play"></span> Docker Exec
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalDockerExec_<?=$row['id'];?>" tabindex="-1" aria-labelledby="modalDockerExecLabel_<?=$row['id'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDockerExecLabel_<?=$row['id'];?>">Провалиться в контейнер проекта</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre>cd ~/Desktop/docker/projects/<?=$row['DOCKER_PROJECT_NAME']?> && docker exec -it --user www-data <?=$row['DOCKER_PROJECT_NAME']?>_web-server_1 bash</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDoc_<?=$row['id'];?>">
                    <span class="glyphicon glyphicon-play"></span> Doc
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalDoc_<?=$row['id'];?>" tabindex="-1" aria-labelledby="modalDocLabel_<?=$row['id'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDocLabel_<?=$row['id'];?>">Документация</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= nl2br($row['DOCUMENTATION']) ?>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <?php
    }
    ?>
    <tr>
        <td colspan="12">
            <pre style="margin: 0;">
docker stop $(docker ps -a -q) # остановить все процессы
docker rm $(docker ps -a -q) # удалить все процессы</pre>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
