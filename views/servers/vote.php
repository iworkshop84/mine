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
        <div id="headernavvote">

            <a href="/"><div id="logo"></div></a>




        </div>
    </div>
</div>


<div class="clear"></div>


<div id="page">

    <div id="postsvote">
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