<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Локальная разработка проектов</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="./assets/jquery.tablesort.js"></script>
    <style type="text/css">
    </style>
</head>
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
<ol class="list-group" style="width: 50%; margin: 0 auto; padding-bottom: 15%;">
    <?php
    foreach ($list as $filename) {
        $port = (new dotenv(__DIR__ . '/' . $filename))->load('PORT');
        $project_name = (new dotenv(__DIR__ . '/' . $filename))->load('PROJECT_NAME');
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="http://localhost:80<?= $port ?>/?t=<?=time();?>" style="color: black; text-decoration: none;">[80<?= $port ?>] <?= dirname($filename); ?></a>
            <span class="badge bg-primary rounded-pill">
                <a href="http://localhost:51<?= $port ?>" style="color: white; text-decoration: none;">phpmyadmin</a> |
                <a href="http://localhost:52<?= $port ?>" style="color: white; text-decoration: none;">adminer</a> |
                <a href="http://localhost:53<?= $port ?>" style="color: white; text-decoration: none;">pgadmin</a>
            </span>
        </li>
        <?php
    }
    ?>
</ol>

</body>
</html>

