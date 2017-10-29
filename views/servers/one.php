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

            <?php if(!empty($items->site)):?>
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
            <?php endif;?>

            <?php if(!empty($items->vk)):?>
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
            <?php endif;?>

            <?php if(!empty($mainprops)):?>
            <p>
                <span class="header">Основное:</span>
                <div class="servmprop">

                   <?php foreach ($mainprops as $mainprop): ?>
                       <div class="servermprop">
                    <a href="<?= '/servers/properties/' . $mainprop->title ?>"
                       title="Сервера Майнкрафт с настройками <?= $mainprop->name ?>">
                        <?= $mainprop->name; ?></a>
                        </div>
                   <?php endforeach; ?>
                </div>
            </p>
            <?php endif;?>


            <p>
                <span class="header">Версия:</span>
                <span class="servversion">
                  <a href="<?= '/servers/all/' . $items->version ?>" title="Сервера Майнкрафт версии <?= $items->version ?>"><?= $items->version; ?></a>
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

            <?php if(!empty($items->banner)):?>
                <div class="serverpagebanner"><img src="/../upload/banners/<?= $items->banner; ?>" alt="Баннер сервера майнкрафт <?= $items->name ?>" title="Баннер сервера майнкрафт <?= $items->name ?>"></div>
            <?php endif;?>
            <div class="clear"></div>

            <button class="serveronevote" href='/servers/vote/<?= $items->id; ?>' onclick="window.open('/servers/vote/<?=$items->id ?>', '', 'toolbar=0,location=0,status=0,left=+500,top=50,menubar=0,scrollbars=yes,resizable=0,width=800,height=600'); return false;">
                Голосовать за сервер</button>
            <div class="clear"></div>
            <?php
            /*
            $url = 'https://www.youtube.com/watch?v=_imOsDY7X9U&list=PLyq3mTLSYg59wT8Ku1dJ5mqMQeS550CIM';
            $url1 = 'https://youtu.be/_imOsDY7X9U';

            $parsed_url = parse_url($url);
            $parsed_url1 = parse_url($url1);
            var_dump($parsed_url);
            var_dump($parsed_url1);
           $res = parse_str($parsed_url['query'], $parsed_query);
           var_dump($parsed_query);
            echo '<iframe src="http://www.youtube.com/embed/' . $parsed_query['v'] . '"
            width="400" height="300" frameborder="0"></iframe>';
            */
            ?>



            <div class="servervideo">
            <?php if(!empty($items->youtube))
            {
                $parsed_url = parse_url($items->youtube);
                parse_str($parsed_url['query'], $parsed_query);

                if(!empty($parsed_url['query']))
                {
                    parse_str($parsed_url['query'], $parsed_query);
                    echo '<iframe src="http://www.youtube.com/embed/' . $parsed_query['v'] . '"
                            width="390" height="260" frameborder="0"></iframe>';
                }else{
                $parsed_path = mb_substr($parsed_url['path'], 1);
                    echo '<iframe src="http://www.youtube.com/embed/' . $parsed_path . '"
                            width="390" height="260" frameborder="0"></iframe>';

                }


            }

            ?>
            </div>



        </div>
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