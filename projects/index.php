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
$list = [];
foreach (glob("*/.env.docker.local") as $filename) {
    $port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
    $list[$port] = $filename;
}
ksort($list);
?>

<h2 style="padding-top: 15%;" align="center">Локальная разработка проектов</h2>

<table class="table table-bordered table-striped" style="width: auto; margin: 0 auto; padding-bottom: 15%;">
    <thead>
    <tr>
        <th>Порт</th>
        <th colspan="2" align="center">URL</th>
        <th>Проект</th>
        <th colspan="3">Сервисы</th>
        <th colspan="3">Команды</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($list as $filename) {
        $port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
        $project_name = (new dotenv(__DIR__ . '/' . $filename))->load('PROJECT_NAME');
        ?>
        <tr>
            <td>[80<?= $port ?>]</td>
            <td><a href="http://localhost:80<?= $port ?>/?t=<?= time(); ?>">http</a></td>
            <td><a href="https://localhost:90<?= $port ?>/?t=<?= time(); ?>">https</a></td>
            <td><?= dirname($filename); ?></td>
            <td><a href="http://localhost:51<?= $port ?>">phpmyadmin</a></td>
            <td><a href="http://localhost:52<?= $port ?>">adminer</a></td>
            <td><a href="http://localhost:53<?= $port ?>">pgadmin</a></td>
            <td>
                <button type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-play"></span> Start
                </button>
            </td>
            <td>
                <button type="button" class="btn btn-primary btn-sm">
                    <span class="glyphicon glyphicon-play"></span> Stop
                </button>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>

</body>
</html>

