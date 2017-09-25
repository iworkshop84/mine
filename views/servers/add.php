<h1>Добавить сервер</h1>



<form action="/Servers/Add" method="post" enctype="multipart/form-data">
    <p> <label for="server"> Адрес: </label>
        <input type="text" id="server" name="server"></p>

    <p> <button type="submit" name="addserver">Отправить</button></p>
</form>

<?php if(!empty($items)): ?>
<a href="<?= '/Servers/One/' . $items?>">Добавленный сервер</a>
<?php endif; ?>
