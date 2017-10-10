<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Профиль</title>
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
            <a href="<?= '/Users/Servers' ?>">Список серверов</a>
            <a href="<?= '/Users/Logout' ?>">Выйти</a>

        </div>
    </div>

</div>
<div id="page">

    <div id="posts">

        <div id="servers">
            <?php foreach ($items as $item): ?>
                <div class="server">
                    <h3><a href="<?= '/Servers/One/' . $item->id ?>"><?= substr($item->name, 0, 50) ?></a></h3>
                    <?php if(!empty($item->host)): ?>
                        <p><?= $item->host . ':' . $item->port ?></p>
                    <?php endif; ?>
                    <p><?= $item->ip . ':' . $item->port ?></p>
                    <p><?= 'Онлайн: ' . $item->players ?></p>
                    <p><?= 'Максимум игроков: ' . $item->maxplayers ?></p>
                    <p><a href="<?= '/Users/Sedit/' . $item->id ?>">Редактировать</a></p>

                </div>
            <?php endforeach; ?>
        </div>


        <?= '<br/><br/><br/>'; ?>

        <form action="/Users/Servers" method="post" enctype="multipart/form-data">
            <p> <label for="server"> Адрес: </label>
                <input type="text" id="server" name="server"></p>

            <p> <button type="submit" name="checkserver">Подтвердить</button></p>
        </form>






        <?php if(isset($error)): ?>
            <?= $error; ?>
        <?php endif; ?>

    </div>

</div>

</body>
</html>