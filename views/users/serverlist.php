<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Список серверов - сервера Майнкрафт</title>
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
                        <li><a href="<?= '/servers/new/' ?>" class="servnew">Новые сервера</a></li>
                        <li><a href="<?= '/servers/add/' ?>" class="servadd">Добавить сервер</a></li>
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

<div class="clear"></div>

<div id="page">

    <div id="posts">

        <?php if(isset($error)): ?>
            <div class="error">
                <div class="error_text"> <?= $error; ?></div>
            </div>
        <?php endif; ?>


        <div class="serverpretext">
            <h2>
                Список серверов пользователя: <?= $_SESSION['login'];?>

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
            <div class="serverlist_status">
                <i class="icon-serverlist_status"></i>
                <span> Статус</span>
            </div>

            <div class="server_headplayers">
                <i class="icon-players"></i>
                <span> Игроков</span>
            </div>
            <div class="server_headversion">
                <i class="icon-version"></i>
                <span> Версия</span>
            </div>
            <div class="serverlist_headvote">
                <i class="icon-vote"></i>
                <span> Голосов</span>
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
                        <a href="<?= '/servers/one/' . $item->id ?>"><?= substr($item->name, 0, 30) . '...' ?></a>
                    </div>
                    <div class="sulipport">
                        <div class="server_status">
                            <div class="server_adres_text"><?= $item->ip . ':' . $item->port ?></div>
                        </div>
                    </div>
                    <div class="sulstatus">
                        <?php if($item->online == 0): ?>
                            <span class="offline">Offline</span>
                        <?php else: ?>
                            <span class="online">Online</span>
                        <?php endif; ?>
                    </div>
                    <div class="sulplayers"><?= $item->players . ' из ' . $item->maxplayers ?></div>
                    <div class="sulversion"><?= $item->version ?></div>
                    <div class="sulvotes"><?= $item->votes ?></div>
                    <div class="suluptime"><?= $item->uptime .'%'; ?></div>

                    <div class="suledit"><a href="<?= '/users/sedit/' . $item->id ?>">Редактировать</a></div>
                    <div class="suldelete"><a href="<?= '/users/sdelete/' . $item->id ?>">Удалить</a></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clear"></div>

        <div id="serverlistcontainer">
            <div class="oservere">
                <span>Подтвердить права на сервер</span>
            </div>
            <div id="serverapruvtext">
                <p>
                    Для того чтобы вы могли менять описание сервера он должен быть закреплён за вами в нашем рейтинге.
                    При добавлении сервера зарегистрированным пользователем он автоматически прикрепляется к нему и больше ничего делать не нужно.
                </p>
                <p>
                    Если же вы добавили сервер будучи незарегистрированным пользователем или же кто-то добавил ваш сервер до вас -
                    вы в любой момент можете подтвердить то, что сервер принадлежит вам и перенести его в свой аккаунт в нашем рейтинге.
                </p>
                <p>
                    Для этого вам нужно изменить название своего сервера так, чтобы оно заказнчивалось на <b><?= 'uid'. $_SESSION['uid']; ?></b>.
                    Чаще всего, чтобы новое название вступило в силу необходимо перезапустить сервер Майнкрафт.
                    После этого добавьте в поле ниже адрес своего сервера в формате <b>ip:порт</b>(например 127.0.0.1:25565) и нажмите подтвердить.
                </p>
                <p>После того, как сервер успешно пройдет проверку, его название можно сменить на первоначальное.</p>

            </div>
        </div>
        <div class="clear"></div>

        <div id="serverlistapp">
        <form action="/users/servers" method="post" enctype="multipart/form-data" id="auth">

            <div class="formgrup"><input class="forminput" type="text" id="server" name="server" placeholder="ip:порт"></div>

            <div class="formgrup"><button class="btn" type="submit" name="checkserver">Подтвердить</button></div>
        </form>

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