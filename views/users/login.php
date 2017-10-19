<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Авторизация - сервера Майнкрафт</title>
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

<div id="page">

    <div id="posts">
        <div id="userauth">
            <h1>Вход в личный кабинет</h1>
        <form action="/Users/Login" method="post" enctype="multipart/form-data" id="auth">

            <div class="formgrup"><input class="forminput" type="text" id="login" name="login" placeholder="Логин"></div>

            <div class="formgrup"><input class="forminput" type="password" id="password" name="password" placeholder="Пароль"></div>


            <div class="formgrup"><button class="btn" type="submit" name="loginuser">Войти</button></div>
        </form>
        </div>
    </div>

</div>

</body>
</html>