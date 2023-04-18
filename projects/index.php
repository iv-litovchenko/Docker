<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Локальная разработка проектов</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./.assets/jquery.tablesort.js"></script>
    <script>
        $(document).ready(function () {
            $('table').tablesort().data('tablesort');
        });
    </script>
    <style type="text/css">
        th {
            cursor: pointer;
        }
        th.no-sort,
        th.no-sort:hover {
            cursor: not-allowed;
        }

        th.sorted.ascending:after {
            content: "  \2191";
        }

        th.sorted.descending:after {
            content: " \2193";
        }
    </style>
</head>
<body>

<?php
require('dotenv.php');

function editIcon($title, $table, $id)
{
    return '<a class="btn btn-primary btn-sm" href="http://ilitovfa.beget.tech/adminer-4.8.1-monitoring.php?server=localhost&username=ilitovfa_monitor&db=ilitovfa_monitor&edit='.strval($table).'&where[id]='.intval($id).'">'.$title.'</a>';
}

function get_readme_md($name) {
    if(file_exists($name.'/readme.md')){
        return nl2br(file_get_contents($name.'/readme.md'));
    }
    if(file_exists($name.'/README.md')){
        return nl2br(file_get_contents($name.'/README.md'));
    }
    return "-";
}

// $list = [];
// foreach (glob("*/") as $filename) {
//     $port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
//     $list[$port] = $filename;
// }
// ksort($list);

// $list = file_get_contents('http://ilitovfa.beget.tech/docker-api/');
// if(empty($list)) {

// }

// $list = json_decode($list, true);
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
        <th><img src="./.assets/icon-cms.png" width="20"></th>
        <th><img src="./.assets/icon-ssh-server-path.png" width="20"></th>
        <th><img src="./.assets/icon-gitlab.png" width="20"></th>
        <th><img src="./.assets/icon-adminpanel.png" width="20"></th>
        <th>DB</th>
        <th>Ci/Cd</th>
        <th>Команды</th>
    </tr>
    </thead>
    <tbody>
    <tr class="no-sort">
        <td colspan="14">
            <pre style="margin: 0; color: red;">При работе внутри контейнера нужно переключиться на пользователя "su www-data"
В PHP-приходит переменная "DOCKER_PROJECT_ENV: local", по ней мождно определить среду работы проекта на локали
Все что нужно для работы проекта на локали помечается как: /* ---- DOCKER LOCAL ---- */

/* ---- DOCKER LOCAL (example) // как отличить продакшин от локальной разработки ---- */
if(getenv("DOCKER_PROJECT_ENV") == 'local') { // localhost
    $db['default']['hostname'] = 'host.docker.internal:6103'; // db-mysql
    $db['default']['username'] = 'root';
    $db['default']['password'] = 'docker_password';
    $db['default']['database'] = 'spravkyfront';
} else {
    $db['default']['hostname'] = 'localhost';
    $db['default']['username'] = '';
    $db['default']['password'] = '';
    $db['default']['database'] = '';
}
</pre>
        </td>
    </tr>
    <?php
    $rows = array_map('str_getcsv', file('db.csv'));
    $header = array_shift($rows);
    foreach ($rows as $data) {
        $row = array_combine($header, $data);

        #$port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
        #$project_name = (new dotenv(__DIR__ . '/' . $filename))->load('PROJECT_NAME');

        $vars = [];
        $vars['DOCKER_PROJECT_NAME'] = $row['DOCKER_PROJECT_NAME'];
        $vars['DOCKER_PROJECT_PUBLIC_PATH'] = $row['DOCKER_PROJECT_PUBLIC_PATH'];
        $vars['DOCKER_PROJECT_PHP_VERSION'] = $row['DOCKER_PROJECT_PHP_VERSION'];
        $vars['DOCKER_PROJECT_NODEJS_VERSION'] = $row['DOCKER_PROJECT_NODEJS_VERSION'];
        $vars['DOCKER_PROJECT_PORT'] = $row['DOCKER_PROJECT_PORT'];
        $vars['DOCKER_PROJECT_NAME'] = $row['DOCKER_PROJECT_NAME'];
        # $vars['DB_CHARSET'] = $row[''];
        # $vars['DB_COLLATE'] = $row[''];

        $commandList = [];
        $commandList[] = " cd ~/Desktop/Docker/projects/".$row['DOCKER_PROJECT_NAME']." ";
        foreach($vars as $k => $v){
            $commandList[] = " export " . $k . "='" . $v . "' ";
        }

        // docker-compose -p <PROJECT FOLDER NAME> --env-file projects/<PROJECT FOLDER NAME>/ .env.docker.local -f docker-compose-project.yml up -d --build
        $commandList = implode(" && " , $commandList);
        $commandUp = $commandList . ' && docker-compose -p "'. $row['DOCKER_PROJECT_NAME'] .'" -f ../../docker-compose-project.yml --env-file ../.env.variables up -d ';
        $commandDown = $commandList . ' && docker-compose -p "'. $row['DOCKER_PROJECT_NAME'] .'" -f ../../docker-compose-project.yml --env-file ../.env.variables down ';
        ?>
        <tr>
            <td style="background: <?php if (file_exists($row['DOCKER_PROJECT_NAME'] . '/')) { echo 'green'; } else { echo 'red'; } ?>">
                &nbsp;
            </td>
            <td><?=$row['DOCKER_PROJECT_PORT'];?></td>
            <td nowrap>
                <a href="http://localhost:80<?= $row['DOCKER_PROJECT_PORT'] ?>/?t=<?= time(); ?>">http</a> |
                <a href="https://localhost:90<?= $row['DOCKER_PROJECT_PORT'] ?>/?t=<?= time(); ?>">https</a>
            </td>
            <td nowrap><?= $row['DOCKER_PROJECT_NAME']; ?></td>
            <td><a href="http://localhost:51<?= $row['DOCKER_PROJECT_PORT'] ?>">phpmyadmin</a></td>
            <td><a href="http://localhost:52<?= $row['DOCKER_PROJECT_PORT'] ?>">adminer</a></td>
            <td><a href="http://localhost:53<?= $row['DOCKER_PROJECT_PORT'] ?>">pgadmin</a></td>
            <td>
                <?php
                    ?> <button type="button" class="btn btn-primary btn-sm"><img src="./.assets/icon-cms.png" width="20" onclick="alert('<?= htmlspecialchars($row['INFO_COMMENT']); ?>')"
                                                                                 data-bs-toggle="tooltip" title="SSH - путь на сервере"></button> <?php
                ?>
            </td>
            <td>
                <?php
                if (!empty($row['INFO_SERVER_PATH'])) {
                    ?> <button type="button" class="btn btn-primary btn-sm"><img src="./.assets/icon-ssh-server-path.png" width="20" onclick="alert('<?= htmlspecialchars($row['INFO_SERVER_PATH']); ?>')"
                            data-bs-toggle="tooltip" title="SSH - путь на сервере"></button> <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (!empty($row['INFO_GITLAB'])) {
                    ?> <button type="button" class="btn btn-primary btn-sm"><img src="./.assets/icon-gitlab.png" width="20" onclick="alert('<?= htmlspecialchars($row['INFO_GITLAB']); ?>')"
                            data-bs-toggle="tooltip" title="Ссылка на gitlab.com"></button> <?php
                }
                ?>
            </td>
            <td>
                <?php
                if (!empty($row['INFO_ADMIN_PANEL'])) {
                    ?> <button type="button" class="btn btn-primary btn-sm"><img src="./.assets/icon-adminpanel.png" width="20" onclick="alert('<?= htmlspecialchars($row['INFO_ADMIN_PANEL']); ?>')"
                            data-bs-toggle="tooltip" title="Ссылка на панель управления сайтом"></button> <?php
                }
                ?>
            </td>
            <td></td>
            <td></td>
            <td nowrap>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStart_<?=$row['DOCKER_PROJECT_PORT'];?>">
                    <span class="glyphicon glyphicon-play"></span> Start
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalStart_<?=$row['DOCKER_PROJECT_PORT'];?>" tabindex="-1" aria-labelledby="modalStartLabel_<?=$row['DOCKER_PROJECT_PORT'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalStartLabel_<?=$row['DOCKER_PROJECT_PORT'];?>">Поднять контейнер</h5>
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

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalStop_<?=$row['DOCKER_PROJECT_PORT'];?>">
                    <span class="glyphicon glyphicon-play"></span> Stop
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalStop_<?=$row['DOCKER_PROJECT_PORT'];?>" tabindex="-1" aria-labelledby="modalStopLabel_<?=$row['DOCKER_PROJECT_PORT'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalStopLabel_<?=$row['DOCKER_PROJECT_PORT'];?>">Опустить контейнер</h5>
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

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDockerExec_<?=$row['DOCKER_PROJECT_PORT'];?>">
                    <span class="glyphicon glyphicon-play"></span> Exec
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalDockerExec_<?=$row['DOCKER_PROJECT_PORT'];?>" tabindex="-1" aria-labelledby="modalDockerExecLabel_<?=$row['DOCKER_PROJECT_PORT'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDockerExecLabel_<?=$row['DOCKER_PROJECT_PORT'];?>">Провалиться в контейнер проекта</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <pre>cd ~/Desktop/Docker/projects/<?=$row['DOCKER_PROJECT_NAME']?> && docker exec -it --user www-data <?=$row['DOCKER_PROJECT_NAME']?>_web-server_1 bash</pre>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalDoc_<?=$row['DOCKER_PROJECT_PORT'];?>">
                    <span class="glyphicon glyphicon-play"></span> Doc.md
                </button>
                <!-- Modal -->
                <div class="modal fade" id="modalDoc_<?=$row['DOCKER_PROJECT_PORT'];?>" tabindex="-1" aria-labelledby="modalDocLabel_<?=$row['DOCKER_PROJECT_PORT'];?>" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalDocLabel_<?=$row['DOCKER_PROJECT_PORT'];?>">Документация</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <?= get_readme_md($row['DOCKER_PROJECT_NAME']) ?>
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
        <td colspan="14" class="no-sort">
            <pre style="margin: 0;">
docker stop $(docker ps -a -q) # остановить все процессы
docker rm $(docker ps -a -q) # удалить все процессы</pre>
        </td>
    </tr>
    </tbody>
</table>

</body>
</html>
