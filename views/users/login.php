<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Авторизация</title>
</head>
<body>
<div id="header">


    <div class="headermenu">
        <div class="topmenu">
            <a href="<?= '/' ?>">Главная страница</a>
            <a href="<?= '/Servers/Add/' ?>">Добавить сервер</a>
            <a href="<?= '/Users/Register' ?>">Зарегистрироваться</a>
            <a href="<?= '/Users/Login' ?>">Авторизация</a>
            <a href="<?= '/Users/Profile' ?>">Профиль</a>
            <a href="<?= '/Users/Logout' ?>">Выйти</a>
        </div>
    </div>

</div>
<div id="page">

    <div id="posts">

        <form action="/Users/Login" method="post" enctype="multipart/form-data">
            <p> <label for="login"> Логин: </label>
                <input type="text" id="login" name="login"></p>
            <p> <label for="password"> Пароль: </label>
                <input type="password" id="password" name="password"></p>


            <p> <button type="submit" name="loginuser">Войти</button></p>
        </form>




    </div>

</div>

</body>
</html>