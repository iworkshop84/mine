<?php foreach ($items as $item): ?>
    <h3><a href="<?= '/Servers/One/' . $item->id?>"><?= $item->title ?></a></h3>
    <p><?= $item->ip ?></p>
<?php endforeach; ?>