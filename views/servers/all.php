<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Сервера Майнкрафт - рейтинг, ip, ТОП серверов Maincraft</title>
    <meta name="description" content="MinecraftRait.ru – это самый лучший мониторинг Майнкрафт серверов в рунете. У нас удобный поиск серверов и объективный рейтинг лучших серверов Minecraft." />
    <meta name="keywords" content="мониторинг серверов, майнкрафт, ip адреса, сервера minecraft, айпи серверов, топ, список, лучшие сервера, рейтинг" />
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
<div id="topnav">
    <div id="navlist">

    <div id="site-about">
        <h1>Сервера Майнкрафт</h1>
        <p>Приветствуем вас на лучшем мониторинге серверов Minecraft(Майнкрафт) - Minecraftrait.Ru.
        В нашем рейтинге вы можете найти сервер для игры Minecraft на любой вкус. Большинство серверов рускоязычные.</p>
        <p>Если вы хотите начать играть на интересующем вас сервере узнайте его IP и порт.</p>
    </div>

    <div id="versionlist">
        <span class="params">
            <span class="label">Все версии</span>
        </span>
        <?php foreach ($versionList as $version): ?>
            <div class="version">
                <a href="<?= '/Servers/All/' . $version->urls ?>" title="Сервера Майнкрафт версии <?= $version->version ?>"><?= $version->version; ?></a>
            </div>
        <?php endforeach; ?>

    </div>


     <div id="mainproplist">
        <span class="params">
            <span class="label">Основное</span>
        </span>
            <?php foreach ($mainpropList as $mainprop): ?>
                <div class="version">
                    <a href="<?= '/Servers/All/' . $mainprop->title ?>" title="Сервера Майнкрафт c <?= $mainprop->name ?>"><?= $mainprop->name; ?></a>
                </div>
            <?php endforeach; ?>
     </div>

    </div>
</div>

<div class="clear"></div>



<div id="page">

    <div id="posts">

        <div id="serverheader">
            <div id="shcount">#</div>
            <div id="shname">Сервер</div>
            <div id="shproph">Сборка</div>
            <div id="shplayers">Игроков</div>
            <div id="shversion">Версия</div>
            <div id="shreith">Рейтинг</div>
        </div>
        <div class="clear"></div>
        <div id="servers">
        <?php foreach ($items as $key=>$item): ?>
            <div class="server">
                <div class="scount"><?= $key + 1 . '.'; ?></div>
                <div class="namelabel">
                    <div class="sname">
                        <a href="<?= '/Servers/One/' . $item->id ?>"><?= substr($item->name, 0, 100) . '...' ?></a>
                    </div>
                    <div class="slogan">
                        <?= substr($item->slogan, 0, 120); ?>
                    </div>


                <?php if(!empty($item->host)): ?>
                <div class="shostport"><?= $item->host . ':' . $item->port ?></div>
                <?php endif; ?>
                <div class="sipport"><?= $item->ip . ':' . $item->port ?></div>
                </div>

                <div class="smainprop"></div>

                <div class="splayers"><?= $item->players .' из '. $item->maxplayers;?></div>

                <div class="sversion"><?= $item->version ?></div>

            </div>
        <?php endforeach; ?>
        </div>


    </div>

</div>

</body>
</html>