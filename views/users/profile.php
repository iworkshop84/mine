<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Профиль - сервера Майнкрафт</title>
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

        <div class="oservere">
            <span>Профиль</span>
        </div>
        <div id="userprofile">

        <form action="/users/profile" method="post" enctype="multipart/form-data" id="proph">
             <div class="userproftitle"> Логин: </div>
            <div class="userformgrup"><input class="forminput" type="text" id="login" name="login" disabled value="<?= $items->login ?>"></div>
            <div class="clear"></div>
            <div class="userproftitle"> Email: </div>
            <div class="userformgrup"><input class="forminput" type="email" id="email" name="email" value="<?= $items->email ?>"></div>
            <div class="clear"></div>

            <p>Смена пароля:</p>
            <div class="clear"></div>
            <div class="userproftitle"> Старый пароль: </div>
            <div class="userformgrup"><input class="forminput" type="password" id="oldpassword" name="oldpassword"></div>
            <div class="clear"></div>
            <div class="userproftitle"> Новый пароль: </div>
            <div class="userformgrup"><input class="forminput" type="password" id="newpassword" name="newpassword"></div>
            <div class="clear"></div>
            <div class="userproftitle"> Повторите пароль: </div>
                <div class="userformgrup"><input class="forminput" type="password" id="reppassword" name="reppassword"></div>
            <div class="clear"></div>
            <div class="buttomform"> <button class="btn" type="submit" name="edituser">Отправить</button></div>
        </form>


        </div>
    </div>
</div>


</div>
<div class="clear"></div>

<?php include_once 'footer.php'?>