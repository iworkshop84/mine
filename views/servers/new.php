<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta name="robots" content="index,follow" />
    <title>Новые сервера Майнкрафт - рейтинг, ip, ТОП серверов Maincraft</title>
    <meta name="description" content="MinecraftRait.ru – это самый лучший мониторинг Майнкрафт серверов в рунете. У нас удобный поиск серверов и объективный рейтинг лучших серверов Minecraft." />
    <meta name="keywords" content="мониторинг серверов, майнкрафт, ip адреса, сервера minecraft, айпи серверов, топ, список, лучшие сервера, рейтинг" />



</head>

<body>

<div class="content">

    <div id="header">
        <div id="headermenu">
            <div id="headernav">

                <a href="/"><div id="logo"></div></a>
                <div id="topmenu">
                    <?php $activeurl = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);?>
                    <ul>
                        <li><a href="<?= '/' ?>">Все сервера</a></li>
                        <li><a href="<?= '/servers/new' ?>" class="servnew<?php if(preg_match('#^/servers/new#', $activeurl) == 1){echo 'activeurl"';}?>">Новые сервера</a></li>
                        <li><a href="<?= '/servers/add' ?>" class="servadd">Добавить сервер</a></li>
                    </ul>

                </div>

                <div id="authmenu">

                    <?php if(isset($_SESSION['uid'])): ?>
                        <ul>
                            <li><a href="<?= '/users/logout' ?>">Выйти</a></li>
                            <li><a href="<?= '/users/profile' ?>" <?php if(preg_match('#^/users/profile#', $activeurl) == 1){echo 'class="activeurl"';}?>>Профиль</a></li>
                            <li><a href="<?= '/users/servers' ?>" <?php if(preg_match('#^/users/servers#', $activeurl) == 1){echo 'class="activeurl"';}?>>Список серверов</a></li>

                        </ul>
                    <?php else: ?>
                        <ul>
                            <li><a href="<?= '/users/register'; ?>" <?php if(preg_match('#^/users/register#', $activeurl) == 1){echo 'class="activeurl"';}?> >Регистрация</a></li>
                            <li><a href="<?= '/users/login'; ?>" <?php if(preg_match('#^/users/login#', $activeurl) == 1){echo 'class="activeurl"';}?> >Войти</a></li>
                        </ul>

                    <?php endif; ?>

                </div>

            </div>
        </div>
    </div>

<div id="topnav">
    <div id="navlist">

    <div id="site-aboutnew">
        <h1>Новыe сервера Maincraft</h1>
        <p>На данной странице представлены новые сервера игры Майнкрафт, добавленные в мониторинг за последнее время. Проверка новых серверов на доступность длится 3 дня. По её результатам, Minecraft сервера со значением аптайм ниже 50% – удаляются, больше 80% – попадают в общий топ MinecraftRating.ru. Если сервер не достигает указанных значений, он продолжает проверяться. </p>
    </div>

    <div id="versionlist_new">
        <span class="params_new">
            <span class="label">Версия:</span>
        </span>
       <?php foreach ($versionList as $version): ?>
            <div class="version">
                <a href="<?= '/servers/new/' . $version->urls ?>"
                   title="Сервера Майнкрафт версии <?= $version->version ?>"

                <?php
                $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
                $res = preg_replace('/[^0-9.]/', '', $path);
                if($res === $version->version){
                    echo 'class="activeurl"';
                }
                ?>><?= $version->version; ?></a>

            </div>
        <?php endforeach; ?>
    </div>




    </div>
</div>

<div class="clear"></div>

<div id="page">

    <div id="posts">


        <div class="serverpretext">
            <h2>
                Мониторинг и рейтинг новых серверов Майнкрафт
            </h2>
        </div>
        <div class="serverprehead">

            <div class="serverlist_headposition">
                <i class="icon-signal"></i>
            </div>
            <div class="serverlist_headname">
                <i class="icon-name"></i>
                <span>Название сервера</span>
            </div>
            <div class="serverlist_ip">
                <i class="icon-serverlist_ip"></i>
                <span> IP Адрес</span>
            </div>

            <div class="containerservernew">
            <div class="serverlist_status">

                <i class="icon-serverlist_status"></i>
                <span> Статус</span>
            </div>
            </div>

            <div class="containerservernew">
            <div class="server_headplayers">
                <i class="icon-players"></i>
                <span> Игроков</span>
            </div>
            </div>


            <div class="containerservernew">
            <div class="server_headversion">
                <i class="icon-version"></i>
                <span> Версия</span>
            </div>
            </div>

            <div class="containerservernew">
            <div class="serverlist_headvote">
                <i class="icon-vote"></i>
                <span> Голосов</span>
            </div>
            </div>


            <div class="server_headuptime">
                <i class="icon-uptime"></i>
                <span> Аптайм</span>
            </div>

        </div>

        <div class="clear"></div>

        <div id="servers">
            <?php foreach ($items as $key=>$item): ?>
                <div class="serveruserlist">
                    <div class="sulcount"><?= $key + 1 . '.'; ?></div>
                    <div class="sulname">
                        <a href="<?= '/servers/one/' . $item->id ?>"><?= substr($item->name, 0, 40) . '...' ?></a>
                    </div>
                    <div class="sulipport">
                        <div class="server_status">
                            <div class="server_adres_text"><?= $item->ip . ':' . $item->port ?></div>
                        </div>
                    </div>
                    <div class="containersnewo">
                    <div class="sulstatus">
                        <?php if($item->online == 0): ?>
                            <span class="offline">Offline</span>
                        <?php else: ?>
                            <span class="online">Online</span>
                        <?php endif; ?>
                    </div>
                    </div>

                    <div class="containersnewp">
                    <div class="sulplayers"><?= $item->players . ' из ' . $item->maxplayers ?></div>
                    </div>

                    <div class="containersnewv">
                    <div class="sulversion"><?= $item->version ?></div>
                    </div>

                    <div class="containersnewvotes">
                    <div class="sulvotes"><?= $item->votes ?></div>
                    </div>

                    <div class="suluptime"><?= $item->uptime .'%'; ?></div>


                </div>
            <?php endforeach; ?>
        </div>

    </div>
</div>
</div>
<div class="clear"></div>


<?php include_once 'footer.php'?>