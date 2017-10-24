<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title><?= $items->name ?> - сервер Майнкрафт</title>
    <meta name="description" content="<?= $items->name ?> - айпи адрес, отзывы и описание сервера на мониторинге Майнкрафт" />
    <meta name="keywords" content="ip адрес, сервера minecraft, рейтинг, описание" />
</head>

<body>
<div id="header">

    <div id="headermenu">
        <div id="headernav">

            <div id="logo"></div>
            <div id="topmenu">

                <a href="<?= '/' ?>">Сервера Майнкрафт</a>
                <a href="<?= '/Servers/Add/' ?>" class="servadd">Добавить сервер</a>

            </div>

            <div id="authmenu">
                <?php if(isset($_SESSION['uid'])): ?>
                    <ul>
                        <li> <a href="<?= '/Users/Logout' ?>">Выйти</a></li>
                        <li><a href="<?= '/Users/Profile' ?>">Профиль</a></li>
                        <li><a href="<?= '/Users/Servers' ?>">Список серверов</a></li>

                    </ul>
                <?php else: ?>
                    <ul>
                        <li><a href="<?= '/Users/Register' ?>">Регистрация</a></li>
                        <li><a href="<?= '/Users/Login' ?>">Войти</a></li>
                    </ul>

                <?php endif; ?>
            </div>

        </div>
    </div>
</div>


<div class="clear"></div>


<div id="page">

    <div id="posts">

    <div id="servertitle">
        <h1><?= $items->name ?></h1>
        <div id="serverslogan">
            <?= $items->slogan ?>
        </div>
    </div>
    <div id="mainserverinfo">

        <div class="oservere">
            <span>О сервере</span>
        </div>
        <div class="clear"></div>

        <div class="serverfullinfo">
            <p>
                <span class="header">IP адрес:</span>
                   <?php if(!empty($items->host)): ?>
                        <span class="host"><?= $items->host . ':' . $items->port ?></span>
                        или
                    <?php endif; ?>
                        <span class="ip"><?= $items->ip . ':' . $items->port ?></span>
            </p>
            <p>
                <span class="header">Статус:</span>
                <?php if($items->online == 0): ?>
                    <span class="offline">Офлайн</span>
                <?php else: ?>
                <span class="online">Онлайн</span>
                <?php endif; ?>
            </p>
            <p>
                <span class="header">Голосов:</span>
                <span class="players"><?= $items->votes; ?></span>
            </p>
            <p>
                <span class="header">Аптайп:</span>
                <span class="players"><?= $items->uptime .'%'; ?></span>
            </p>
            <p>
                <span class="header">Игроков:</span>
                    <span class="players"><?= $items->players . ' из ' . $items->maxplayers ?></span>
            </p>
            <p>
                <span class="header">Проверялся:</span>
                <span class="players">
                    <?php
                    $startTime = date_create($items->updtime);
                    $endTime   = date_create();
                    $diff = date_diff($startTime, $endTime);
                    $timepust = $diff->format('%i');

                    if(($timepust == 0) || ($timepust > 4)){
                        echo $timepust . ' минут назад';
                    }elseif($timepust == 1){
                        echo $timepust . ' минуту назад';
                    }else {
                        echo $timepust . ' минуты назад';
                    }
                    ?>
                </span>
            </p>
            <p>
                <span class="header">Сайт сервера:</span>
                <span class="servsite">
                    <?php
                    if((empty(preg_match('~^(http://)|(https://)~', $items->site)) && !empty($items->site))){
                        $items->site = "http://" . $items->site;
                    }
                    ?>
                    <a href="<?= $items->site ?>"target="_blank"><?= $items->site; ?></a>
                </span>
            </p>
            <p>
                <span class="header">Сервер в ВК:</span>
                <span class="servvk">
                    <?php
                    if((empty(preg_match('~^(http://)|(https://)~', $items->vk)) && !empty($items->vk))){
                        $items->vk = "https://" . $items->vk;
                    }
                    ?>
                    <a href="<?= $items->vk ?>" target="_blank"><?= $items->vk; ?></a>
                </span>
            </p>
            <p>
                <span class="header">Версия:</span>
                <span class="servversion">
                  <a href="<?= '/Servers/All/' . $items->version ?>" title="Сервера Майнкрафт c <?= $items->version ?>"><?= $items->version; ?></a>
                </span>
            </p>
            <div class="oservere">
                <span>Описание</span>
            </div>
            <div class="clear"></div>
                <div class="serverdesc">
                    <?php
                    if(!empty($items->description)){
                        echo $items->description;
                    }else{
                        echo 'Владелец сервера «' . $items->name . '» ещё не добавил описание. 
                              Если это ваш сервер, добавьте к нему описание в <a href="/users/servers">личном кабинете</a>.';
                    }
                    ?>
                </div>
        </div>

    </div>
<div id="rightsidebar">
    <button class="serveronevote" href='/servers/vote/<?=$items->id ?>' onclick="window.open('/servers/vote/<?=$items->id ?>', '', 'toolbar=0,location=0,status=0,left=+500,top=50,menubar=0,scrollbars=yes,resizable=0,width=800,height=600'); return false;">
        Голосовать за сервер</button>
</div>

    </div>

</div>

</body>
</html>