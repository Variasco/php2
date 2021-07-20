<?php if ($isAuth): ?>
    Привет, <?= $userName ?> <a href="/auth/logout">Выйти</a>
<?php else: ?>
    <form action="/auth/login" method="post">
        <input type="text" name="login" placeholder="login">
        <input type="password" name="pass" placeholder="password">
        <span>Save</span><input type="checkbox" name="save">
        <button type="submit" name="submit">Войти</button>
    </form>
<?php endif; ?><br>
<a href="/">Главная</a>
<a href="/product">Каталог</a>
<a href="/cart">Корзина[<span id="count"><?= $count ?? 0?></span>]</a>
<?php if ($isAdmin): ?>
    <a href="/admin">Админка</a>
<?php endif; ?>
<br>

<script defer src="/js/sendRequest.js?<?= uniqid(); ?>"></script>
