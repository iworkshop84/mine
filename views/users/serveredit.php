<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />

    <title>Редактировать</title>
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



        <form action="/Users/Sedit/<?= $items->id ?>" method="post" enctype="multipart/form-data">
            <p> <label for="name"> Название сервера: </label>
                <input type="text" id="name" name="name" value="<?= $items->name ?>"></p>
            <p> <label for="slogan"> Слоган: </label>
                <input type="text" id="slogan" name="slogan" value="<?= $items->slogan ?>"></p>
            <p> <label for="host"> Домен: </label>
                <input type="text" id="host" name="host" value="<?= $items->host ?>"></p>
            <p> <label for="description"> Описание: </label>
                <input type="text" id="description" name="description" value="<?= $items->description ?>"></p>
            <p> <label for="site"> Сайт сервера: </label>
                <input type="text" id="site" name="site" value="<?= $items->site ?>"></p>
            <p> <label for="vk"> Группа ВКонтакте: </label>
                <input type="text" id="vk" name="vk" value="<?= $items->vk ?>"></p>
            <p> <label for="youtube"> Видео сервера: </label>
                <input type="text" id="youtube" name="youtube" value="<?= $items->youtube ?>"></p>
            <p> <label for="version"> Версия сервера: </label>

                <select name="version">

                    <option value="<?= $items->version ?>"> <?= 'Авто-определение: ' . '(' .$items->version . ')' ?> </option>
                    <?php foreach ($serverlist as $id=>$list):?>
                         <option value="<?= $list->data['version'] ?>"> <?= $list->data['version'] ?> </option>
                    <?php endforeach; ?>
                </select>
            </p>

            <p> <label for="mainprop"> Основные параметры: </label></p>




            <p> <select name="mainprop[]" multiple size="10">



                        <?php foreach ($mainproplistall as $list):?>

                                <?php if(in_array($list->data['id'], $mplistarr)): ?>
                                    <option value="<?= $list->data['id'] ?>" selected> <?= $list->data['name']  ?> </option>
                                <?php else: ?>
                                    <option value="<?= $list->data['id'] ?>"> <?= $list->data['name']  ?> </option>
                                <?php endif; ?>

                    <?php endforeach; ?>
                </select>
            </p>




            <p> <button type="submit" name="editserver">Отправить</button></p>
        </form>

        <?php if(isset($error)): ?>
            <?= $error; ?>
        <?php endif; ?>




    </div>

</div>

</body>
</html>