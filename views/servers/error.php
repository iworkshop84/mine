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

        <h1><?= 'Ошибка'; ?></h1>

        <div><b><?= $error; ?></b></div>






        </div>



    </div>

</div>

</body>
</html>
