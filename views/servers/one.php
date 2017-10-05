<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title><?= $items->name ?></title>
</head>
<body>
<div id="header">


    <div class="headermenu">
        <div class="topmenu">
            <a href="<?= '/' ?>">Главная страница</a>
            <a href="<?= '/Servers/Add/' ?>">Добавить сервер</a>
            <a href="<?= '/Users/Register' ?>">Зарегистрироваться</a>
            <a href="<?= '/Users/Login' ?>">Авторизация</a>
            <a href="<?= '/Users/Profile' ?>">Профиль</a>
            <a href="<?= '/Users/Logout' ?>">Выйти</a>
        </div>
    </div>

</div>
<div id="page">

    <div id="posts">




        <h1><?= $items->name ?></h1>
        <div><?= $items->ip . ':' . $items->port ?></div>
        <div><?= $items->host ?></div>
        <div><?= $items->version ?></div>



    </div>

</div>

</body>
</html>