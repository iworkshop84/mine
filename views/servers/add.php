<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Добавить сервер Майнкрафт</title>
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


<div id="page">

    <div id="posts">
        <div id="userauth">
            <h1>Добавить сервер</h1>
        <form action="/servers/add" method="post" enctype="multipart/form-data" id="auth">

            <div class="formgrup"><input class="forminput" type="text" id="server" name="server" placeholder="Адрес:Порт"></div>

            <div class="formgrup"><button class="btn" type="submit" name="addserver">Отправить</button></div>
        </form>
        </div>

        <?php if(!empty($items)): ?>
            <a href="<?= '/servers/one/' . $items?>">Ваш добавленный сервер</a>
        <?php endif; ?>

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
