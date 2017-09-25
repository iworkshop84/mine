<?php foreach ($items as $item): ?>
    <h3><a href="<?= '/Servers/One/' . $item->id?>"><?= $item->ip . ':' . $item->port?></a></h3>
    <p><?= $item->name ?></p>
<?php endforeach; ?>


<?php
echo '<br/><br/><br/><br/><br/>';
?>
<h3><a href="<?= '/Servers/Add/' ?>">Добавить сервер</a></h3>