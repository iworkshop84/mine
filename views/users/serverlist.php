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

        <div id="serverheader">
            <div id="shcount">#</div>
            <div id="shulname">Название</div>
            <div id="shuladress">Адрес</div>
            <div id="shulstatus">Статус</div>
            <div id="shulplayers">Игроков</div>
            <div id="shulversion">Версия</div>
            <div id="shulreith">Рейтинг</div>

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

                        <span class="ip"><?= $item->ip . ':' . $item->port ?></span>
                    </div>
                    <div class="sulstatus">
                        <?php if($item->online == 0): ?>
                            <span class="offline">Офлайн</span>
                        <?php else: ?>
                            <span class="online">Онлайн</span>
                        <?php endif; ?>
                    </div>
                    <div class="sulplayers"><?= $item->players . ' из ' . $item->maxplayers ?></div>
                    <div class="sulversion"><?= $item->version ?></div>
                    <div class="sulvotes"><?= $item->votes ?></div>

                    <div class="suledit"><a href="<?= '/users/sedit/' . $item->id ?>">Редактировать</a></div>
                    <div class="suldelete"><a href="<?= '/users/sdelete/' . $item->id ?>">Удалить</a></div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="clear"></div>

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
        <div class="clear"></div>

        <div id="serverlistapp">
        <form action="/users/servers" method="post" enctype="multipart/form-data" id="auth">

            <div class="formgrup"><input class="forminput" type="text" id="server" name="server" placeholder="ip:порт"></div>

            <div class="formgrup"><button class="btn" type="submit" name="checkserver">Подтвердить</button></div>
        </form>

        </div>




        <?php if(isset($error)): ?>
            <?= $error; ?>
        <?php endif; ?>

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