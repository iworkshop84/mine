<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="/views/servers/style.css" type="text/css" media="screen" />
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <title>Редактировать сервер</title>
    <meta name="description" content="MinecraftRait.ru – это самый лучший мониторинг Майнкрафт серверов в рунете. У нас удобный поиск серверов и объективный рейтинг лучших серверов Minecraft." />
    <meta name="keywords" content="мониторинг серверов, майнкрафт, ip адреса, сервера minecraft, айпи серверов, топ, список, лучшие сервера, рейтинг" />

    <script src='/views/servers/js/tinymce/tinymce.min.js'></script>

    <script>
        tinymce.init({
            selector: 'textarea.setextfield',
            width: 735, height: 250,
            plugins: 'lists advlist',
            toolbar: 'undo, redo | bold, italic, underline, strikethrough | bullist, numlist | alignleft, aligncenter, alignright | outdent, indent | fontselect',
            menubar: false
        });
    </script>

</head>

<body>
<div class="content">
<div id="header">

    <div id="headermenu">
        <div id="headernav">

            <a href="/"><div id="logo"></div></a>
            <div id="topmenu">

                <a href="<?= '/' ?>">Сервера Майнкрафт</a>
                <a href="<?= '/servers/new/' ?>" class="servnew">Новые сервера</a>
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
        <div id="servertitle"> <h1><?= $items->name ?></h1></div>
        <div id="warning">
            <p>Пожалуйста, указывайте параметры, которые действительно присутствуют на вашем сервере!</p>
        </div>
        <div class="clear"></div>



            <form id="edit-server" action="/users/sedit/<?= $items->id ?>" method="post" enctype="multipart/form-data">

                <div class="editservertextblock">
                    <span class="estitle">Основные параметры</span>
                    <span class="estext">
                    <p>Определяют, в какие категории попадет ваш сервер.
                        Выбирайте только те параметры, которые действительно присутствуют на вашем сервере. В противном случае, редактирование сервера будет отключено, а сам сервер понижен в рейтинге.</p>
                    <p>Для выбора нескольких параметров нажмите и держите <b>ctrl</b> на клавиатуре в процессе выбора.</p>
                    <p><b>Внимание!</b> В случае полного игнорирования правил выбора параметров, сервер будет удален из мониторинга без возможности восстановления!</p>
                </span>
                </div>

                <div class="servereditfield">
                    <select name="mainprop[]" multiple size="10" class="semproph">

                        <?php foreach ($mainproplistall as $list):?>
                            <?php if(in_array($list->data['id'], $mplistarr)): ?>
                                <option value="<?= $list->data['id'] ?>" selected> <?= $list->data['name']  ?> </option>
                            <?php else: ?>
                                <option value="<?= $list->data['id'] ?>"> <?= $list->data['name']  ?> </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>




                <div class="editservertextblock">
                    <span class="estitle">Название сервера</span>
                    <span class="estext">
                        Не нужно размещать здесь призывы переходить на сервер, для этого есть поле "Слоган".
                        Разрешены буквы и цифры.
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="name" name="name" value="<?= $items->name ?>"></div>
                <div class="clear"></div>



                <div class="editservertextblock">
                    <span class="estitle">Версия сервера</span>
                    <span class="estext">
                    Версия ядра вашего сервера.
                    Если определённая автоматически версия отличается от реальной вы можете поставить её вручную.
                </span>
                </div>
                <div class="servereditfield">
                    <select name="version" class="seversion">
                        <option value="<?= $items->version ?>"> <?= 'Авто-определение: ' . '(' .$items->version . ')' ?> </option>
                        <?php foreach ($serverlist as $id=>$list):?>
                            <option value="<?= $list->data['version'] ?>"> <?= $list->data['version'] ?> </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="clear"></div>



                  <div class="editservertextblock">
                    <span class="estitle">Слоган</span>
                    <span class="estext">
                        Краткое описание, которое будет отображаться в списке серверов сразу под названием. До 150 символов.
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="slogan" name="slogan" value="<?= $items->slogan ?>"></div>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Домен</span>
                    <span class="estext">
                         Домен, по которому также доступен ваш сервер.
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="host" name="host" value="<?= $items->host ?>"></div>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Описание</span>
                    <span class="estext">
                        Полное описание сервера, отображающееся на странице сервера.
                    </span>
                </div>
                <div class="servereditfield"><textarea class="setextfield" type="text" id="description" name="description"><?= $items->description ?></textarea></div>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Баннер</span>
                    <span class="estext">
                        Баннер вашего сервера в формате gif, png или jpg размером 468x60 пикселей.
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="file" id="banner" name="banner"></div>
                <?php if(!empty($items->banner)):?>
                    <div class="servereditbanner"><img src="/../upload/banners/<?= $items->banner; ?>" alt="баннер <?= $items->name ?>" ></div>
                <?php endif;?>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Сайт сервера</span>
                    <span class="estext">
                        Ссылка на сайт вашего сервера в формате: <b>http://site.ru, http://www.site.ru или http://сайт.рф</b>
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="site" name="site" value="<?= $items->site ?>"></div>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Группа ВКонтакте</span>
                    <span class="estext">
                        Ссылка на группу ВКонтакте вашего сервера в формате в формате: <b>https://vk.com/minecraftserver</b>
                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="vk" name="vk" value="<?= $items->vk ?>"></div>
                <div class="clear"></div>


                <div class="editservertextblock">
                    <span class="estitle">Видео сервера</span>
                    <span class="estext">
                        Вы можете разместить ссылку на видео-обзор сервера с YouTube.
                        Для этого скопируйте ссылку из раздела "Поделиться" или же из адресной строки. <br/>Работать будут оба варианта.

                    </span>
                </div>
                <div class="servereditfield"><input class="setextfield" type="text" id="youtube" name="youtube" value="<?= $items->youtube ?>"></div>
                <div class="clear"></div>











            <div class="buttomform"><button class="btn" type="submit" name="editserver">Сохранить изменения</button></div>
        </form>

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