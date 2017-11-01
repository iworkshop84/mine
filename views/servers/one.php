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

           <div class="server_singleline">
            <div class="serversingle_adress">
                <i class="icon-serversingle_adress"></i>
                <span>IP адрес:</span>
            </div>

             <div class="serversingle_ip">
                 <?php if(!empty($items->host)): ?>
                 <div class="server_status">
                     <div class="server_adres_text"><?= $items->host . ':' . $items->port ?></div>
                 </div>
                     или
                 <?php endif; ?>
                 <div class="server_status">
                     <div class="server_adres_text"><?= $items->ip . ':' . $items->port ?></div>
                 </div>
             </div>
           </div>


            <div class="server_singleline">
            <div class="serversingle_vote">
                <i class="icon-serversingle_vote"></i>
                <span>Голосов:</span>
            </div>
                <div class="serversingle_votetext">

                    <?= $items->votes; ?>
                </div>
            </div>


            <div class="server_singleline">
                <div class="serversingle_status">
                    <i class="icon-serversingle_status"></i>
                    <span>Статус:</span>
                </div>
                <div class="serversingle_statustext">

                    <?php if($items->online == 0): ?>
                        <span class="offline">Offline</span>
                    <?php else: ?>
                        <span class="online">Online</span>
                    <?php endif; ?>
                </div>
            </div>


            <div class="server_singleline">
                <div class="serversingle_version">
                    <i class="icon-serversingle_version"></i>
                    <span>Версия:</span>
                </div>
                <div class="serversingle_versiontext">
                    <a href="<?= '/servers/all/' . $items->version ?>"
                       title="Сервера Майнкрафт версии <?= $items->version ?>"><?= $items->version; ?></a>
                </div>
            </div>


            <div class="server_singleline">
                <div class="serversingle_uptime">
                    <i class="icon-serversingle_uptime"></i>
                    <span>Аптайм:</span>
                </div>
                <div class="serversingle_uptimetext">
                    <?= $items->uptime .'%'; ?>

                </div>
            </div>


            <div class="server_singleline">
                <div class="serversingle_players">
                    <i class="icon-serversingle_players"></i>
                    <span>Игроков:</span>
                </div>
                <div class="serversingle_playerstext">
                    <?= $items->players . ' / ' . $items->maxplayers; ?>

                </div>
            </div>


            <div class="server_singleline">
                <div class="serversingle_check">
                    <i class="icon-serversingle_check"></i>
                    <span>Проверялся:</span>
                </div>
                <div class="serversingle_checktext">
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
                </div>
            </div>


            <?php if(!empty($items->site)):?>
            <div class="server_singleline">
                <div class="serversingle_site">
                    <i class="icon-serversingle_site"></i>
                    <span>Сайт сервера:</span>
                </div>
                <div class="serversingle_sitetext">
                    <?php
                    if((empty(preg_match('~^(http://)|(https://)~', $items->site)) && !empty($items->site))){
                        $items->site = "http://" . $items->site;
                    }
                    ?>
                    <a href="<?= $items->site ?>" target="_blank" rel="nofollow"><?= $items->site; ?></a>
                </div>
            </div>
            <?php endif;?>


            <?php if(!empty($items->vk)):?>
                <div class="server_singleline">
                    <div class="serversingle_vk">
                        <i class="icon-serversingle_vk"></i>
                        <span>Сервер в ВК:</span>
                    </div>
                    <div class="serversingle_vktext">
                        <?php
                        if((empty(preg_match('~^(http://)|(https://)~', $items->vk)) && !empty($items->vk))){
                            $items->vk = "https://" . $items->vk;
                        }
                        ?>
                        <a href="<?= $items->vk ?>" target="_blank" rel="nofollow"><?= $items->vk; ?></a>
                    </div>
                </div>
            <?php endif;?>


            <?php if(!empty($mainprops)):?>
                <div class="server_singleline">
                    <div class="serversingle_mainoprop">
                        <i class="icon-serversingle_mainoprop"></i>
                        <span>Основное:</span>
                    </div>
                    <div class="serversingle_mainoproptext">
                        <?php foreach ($mainprops as $mainprop): ?>
                        <div class="serversingle_servermprop">
                                <a href="<?= '/servers/properties/' . $mainprop->title ?>"
                                   title="Сервера Майнкрафт с настройками <?= $mainprop->name ?>">
                                    <?= $mainprop->name; ?></a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif;?>
            <div class="clear"></div>
            <div class="oservere">
                <span>Описание</span>
            </div>

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
        <div class="clear"></div>










    </div>

        <div id="rightsidebar">

            <?php if(!empty($items->banner)):?>
                <div class="serverpagebanner"><img src="/../upload/banners/<?= $items->banner; ?>" alt="Баннер сервера майнкрафт <?= $items->name ?>" title="Баннер сервера майнкрафт <?= $items->name ?>"></div>
            <?php endif;?>
            <div class="clear"></div>

            <button class="serveronevote" href='/servers/vote/<?= $items->id; ?>' onclick="window.open('/servers/vote/<?=$items->id ?>', '', 'toolbar=0,location=0,status=0,left=+500,top=50,menubar=0,scrollbars=yes,resizable=0,width=800,height=600'); return false;">
                Голосовать за сервер</button>
            <div class="clear"></div>




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