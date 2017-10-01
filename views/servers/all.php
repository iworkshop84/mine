<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Главная страница рейтинга серверов</title>
</head>
<body>
<div id="header">



    <div class="headermenu">
        <div class="topmenu">
            <a href="<?= '/' ?>">Главная страница</a>
            <a href="<?= '/Servers/Add/' ?>">Добавить сервер</a>
        </div>
    </div>

    <div id="versionlist">
    <?php foreach ($versionList as $version): ?>
        <div class="version">
            <a href="<?= '/Servers/All/' . $version->version ?>"><?= $version->version; ?></a>
        </div>
    <?php endforeach; ?>
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
                <p><?= 'Версия: ' . $item->version ?></p>

            </div>
        <?php endforeach; ?>
        </div>


    </div>

</div>

</body>
</html>