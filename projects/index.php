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
    <?php
    foreach ($list as $row) {
        #$port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
        #$project_name = (new dotenv(__DIR__ . '/' . $filename))->load('PROJECT_NAME');

        $vars = [];
        $vars['PROJECT_NAME'] = $row['PROJECT_NAME'];
        $vars['PROJECT_PUBLIC_PATH'] = $row['PROJECT_PUBLIC_PATH'];
        $vars['PHP_VERSION'] = $row['PHP_VERSION'];
        $vars['NODEJS_VERSION'] = $row['NODEJS_VERSION'];
        $vars['PROJECT_NAME'] = $row['PROJECT_NAME'];
        $vars['PORT'] = $row['PORT'];
        $vars['DB_NAME'] = $row['DB_NAME'];
        # $vars['DB_CHARSET'] = $row[''];
        # $vars['DB_COLLATE'] = $row[''];

        $commandList = [];
        $commandList[] = " cd ~/Desktop/docker && ";
        foreach($vars as $k => $v){
            $commandList[] = " export " . $k . "='" . $v . "' ";
        }

        // docker-compose -p <PROJECT FOLDER NAME> --env-file projects/<PROJECT FOLDER NAME>/ .env.docker.local -f docker-compose-project.yml up -d --build
        $commandList = implode(" && " , $commandList);
        $commandUp = $commandList . ' && docker-compose -p "bitza-auto" -f ../../docker-compose-project.yml up -d ';
        $commandDown = $commandList . ' && docker-compose -p "bitza-auto" -f docker-compose-project.yml down ';
        ?>
        <tr>
            <td style="background: <?php if (file_exists($row['PROJECT_NAME'] . '/')) { echo 'green'; } else { echo 'red'; } ?>">
                &nbsp;
            </td>
            <td>[X0<?= $row['PORT'] ?>]</td>
            <td nowrap>
                <a href="http://localhost:80<?= $row['PORT'] ?>/?t=<?= time(); ?>">http</a> |
                <a href="https://localhost:90<?= $row['PORT'] ?>/?t=<?= time(); ?>">https</a>
            </td>
            <td><?= $row['PROJECT_NAME']; ?></td>
            <td><a href="http://localhost:51<?= $row['PORT'] ?>">phpmyadmin</a></td>
            <td><a href="http://localhost:52<?= $row['PORT'] ?>">adminer</a></td>
            <td><a href="http://localhost:53<?= $row['PORT'] ?>">pgadmin</a></td>
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
                                <h5 class="modal-title" id="modalStartLabel_<?=$row['id'];?>">Документация</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Данную команду выполнить в корне проекта
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
                                <h5 class="modal-title" id="modalStopLabel_<?=$row['id'];?>">Документация</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                Данную команду выполнить в корне проекта
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
    </tbody>
</table>

</body>
</html>
