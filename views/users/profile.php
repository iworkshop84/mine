<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Профиль</title>
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
            <a href="<?= '/Users/Servers' ?>">Список серверов</a>
            <a href="<?= '/Users/Logout' ?>">Выйти</a>

        </div>
    </div>

</div>
<div id="page">

    <div id="posts">



        <form action="/Users/Profile" method="post" enctype="multipart/form-data">
            <p> <label for="login"> Логин: </label>
                <input type="text" id="login" name="login" disabled value="<?= $items->login ?>"></p>
            <p> <label for="email"> Email: </label>
                <input type="email" id="email" name="email" value="<?= $items->email ?>"></p>
            <p>Сменить пароль:</p>
            <p> <label for="oldpassword"> Старый пароль: </label>
                <input type="text" id="oldpassword" name="oldpassword"></p>
            <p> <label for="newpassword"> Новый пароль: </label>
                <input type="text" id="newpassword" name="newpassword"></p>
            <p> <label for="reppassword"> Повторите пароль: </label>
                <input type="text" id="reppassword" name="reppassword"></p>

            <p> <button type="submit" name="edituser">Отправить</button></p>
        </form>

        <?php if(isset($error)): ?>
            <?= $error; ?>
        <?php endif; ?>

    </div>

</div>

</body>
</html>