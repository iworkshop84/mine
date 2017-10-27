<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title> Прголосовать за сервер <?= $items->name ?> </title>
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
        <div id="votetitle">
            <span class="text">Голосовать за сервер:</span> <span class="name"><?= $items->name?></span>
        </div>

        <div id="votecount">
            <span class="text"> Голосов:</span>
            <span class="count"><?= $items->votes ?></span>
        </div>

        <div class="clear"></div>
        <div id="vstoptext">
            <span class="text"> Голосовать за сервер можно раз в 24 часа!</span>
        </div>
        <div class="clear"></div>


        <form action="/servers/vote/<?= $items->id ?>" method="post" enctype="multipart/form-data" id="vote">
            <div class="formgrup"><button class="serveronevote" type="submit" name="uservote">Голосовать</button></div>
        </form>

    </div>

</div>

</body>
</html>