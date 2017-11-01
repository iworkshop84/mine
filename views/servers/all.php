<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">
    <meta name="robots" content="index,follow" />
    <title>Сервера Майнкрафт - рейтинг, ip, ТОП серверов Maincraft</title>
    <meta name="description" content="MinecraftRait.ru – это самый лучший мониторинг Майнкрафт серверов в рунете. У нас удобный поиск серверов и объективный рейтинг лучших серверов Minecraft." />
    <meta name="keywords" content="мониторинг серверов, майнкрафт, ip адреса, сервера minecraft, айпи серверов, топ, список, лучшие сервера, рейтинг" />



</head>

<body>

<div class="content">

<div id="header">

    <div id="headermenu">
    <div id="headernav">

        <div id="logo"></div>
        <div id="topmenu">

                <a href="<?= '/' ?>">Сервера Майнкрафт</a>
                <a href="<?= '/servers/add/' ?>" class="servadd">Добавить сервер</a>

        </div>

        <div id="authmenu">

            <?php if(isset($_SESSION['uid'])): ?>
                <ul>
                    <li> <a href="<?= '/users/logout' ?>">Выйти</a></li>
                    <li><a href="<?= '/users/profile' ?>">Профиль</a></li>
                    <li><a href="<?= '/users/servers' ?>">Список серверов</a></li>

                </ul>
            <?php else: ?>
                <ul>
                    <li><a href="<?= '/users/register' ?>">Регистрация</a></li>
                    <li><a href="<?= '/users/login' ?>">Войти</a></li>
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
                <a href="<?= '/servers/all/' . $version->urls ?>"
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


     <div id="mainproplist">
        <span class="params">
            <span class="label">Основное</span>
        </span>
            <?php foreach ($mainpropList as $mainprop): ?>
                <div class="version">
                    <a href="<?= '/servers/properties/' . $mainprop->title ?>" title="Сервера Майнкрафт c настройками <?= $mainprop->name ?>"
                        <?php
                        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

                        $res = strripos($path, $mainprop->title);
                        if($res){
                            echo 'class="activeurl"';
                        }
                        ?>><?= $mainprop->name; ?></a>
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
                Рейтинг и мониторинг серверов Minecraft
            </h2>
        </div>
        <div class="serverprehead">

            <div class="server_headposition">
            <i class="icon-signal"></i>
            </div>
            <div class="server_headname">
                <i class="icon-name"></i>
                <span>Название слоган и адрес</span>
            </div>
            <div class="server_headbanner">
                <i class="icon-banner"></i>
                <span> Баннер</span>
            </div>

            <div class="server_headversion">
                <i class="icon-version"></i>
                <span> Версия</span>
            </div>

            <div class="server_headplayers">
                <i class="icon-players"></i>
                <span> Игроков</span>
            </div>

            <div class="server_headuptime">
                <i class="icon-uptime"></i>
                <span> Аптайм</span>
            </div>

            <div class="server_headvote">
                <i class="icon-vote"></i>
                <span> Рейтинг</span>
            </div>

        </div>

        <div class="clear"></div>

        <?php foreach ($items as $key=>$item): ?>
            <div class="server_info" <?php if($item->online == 0){echo 'style="opacity: 0.5"';}?>>
                <div class="server-info__wrap">

                    <div class="server_num">
                        <?= $key + 1 . '.'; ?>
                    </div>

                    <div class="server_name">
                        <a href="<?= '/servers/one/' . $item->id; ?>" class="hostname"><?= $item->name; ?></a>
                    </div>

                    <div class="server_slogan">
                        <?= substr($item->slogan, 0, 70); ?>
                    </div>

                    <div class="server_adres">
                            <div class="server_status">

                            <?php if(!empty($item->host)): ?>

                                <div class="server_adres_text"> <?= $item->host . ':' . $item->port; ?></div>
                            <?php else: ?>
                                <div class="server_adres_text"><?= $item->ip . ':' . $item->port; ?></div>
                            <?php endif; ?>

                            </div>
                    </div>


                </div>


                <div class="server_banner">
                    <?php if(!empty($item->banner)):?>
                        <img src="/../upload/banners/<?= $item->banner; ?>" alt="Баннер сервера майнкрафт <?= $item->name ?>"
                             title="Баннер сервера майнкрафт <?= $item->name ?>">
                    <?php endif;?>



                </div>



                <div class="server_propherties">
                    <div class="version_serverlist">
                        <a href="<?= '/servers/all/' . $item->version; ?>"
                           title="Сервера Майнкрафт версии <?= $item->version; ?>"><?= $item->version; ?></a>
                    </div>
                    <div class="players_serverlist">
                        <?= $item->players .' / '. $item->maxplayers;?>
                    </div>
                    <div class="uptime_serverlist">
                        <?= $item->uptime . '%';?>
                    </div>



                </div>




                <div class="server_vote">

                    <div class="vote_serverlist">
                        <?= $item->votes; ?>
                    </div>
                </div>

            </div>

        <?php endforeach; ?>




    </div>
</div>
</div>
<div class="clear"></div>

<div class="footer">
    <div id="headermenu">
        <div id="headernav">

            <div id="logo"></div>
            <div id="fcopywrait">
                Сервера майнкрафт с модами - © 2017-<?=  date('Y');?> Minecraft Rait - Мониторинг серверов Майнкрафт
            </div>

        </div>
    </div>
</div>




</body>
</html>