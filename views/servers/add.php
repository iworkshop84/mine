<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Добавить сервер</title>
</head>
<body>
<div id="header">


    <div class="headermenu">
        <div class="topmenu">
            <a href="<?= '/' ?>">Главная страница</a>
            <a href="<?= '/Servers/Add/' ?>">Добавить сервер</a>
        </div>
    </div>

</div>
<div id="page">

    <div id="posts">



        <form action="/Servers/Add" method="post" enctype="multipart/form-data">
            <p> <label for="server"> Адрес: </label>
                <input type="text" id="server" name="server"></p>

            <p> <button type="submit" name="addserver">Отправить</button></p>
        </form>

        <?php if(!empty($items)): ?>
            <a href="<?= '/Servers/One/' . $items?>">Ваш добавленный сервер</a>
        <?php endif; ?>

        <?php if(isset($error)): ?>
            <?= $error; ?>
        <?php endif; ?>


    </div>

</div>

</body>
</html>
