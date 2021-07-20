<section class="cart">
    <h2>Корзина</h2>
    <?php if (!empty($cart)): ?>
        <?php foreach ($cart as $good): ?>
            <div class="cart-good">
                <h4><?= $good['name'] ?></h4>
                <p><?= $good['price'] ?> &#8381;</p>
                <p>Количество: <?= $good['quantity'] ?></p>
                <button class="delete" data-id="<?= $good['cart_id'] ?>">Удалить</button>
            </div>
        <?php endforeach; ?>
        <p class="total">Итого: <span id="totalCart"><?= $total ?></span> &#8381;</p>
        <button id="clear-cart">Очистить корзину</button>
    <?php else: ?>
        <p>Корзина пуста</p>
    <?php endif; ?>
</section>
<?php if (!empty($cart)): ?>
    <section>
        <h2>Оформление заказа</h2>
        <?php if (isset($message)): ?>
            <p><?= $message ?></p>
        <?php endif; ?>
        <form action="/cart/order" method="post">
            <input type="text" name="name" placeholder="Имя" required>
            <input type="text" name="phone" placeholder="Телефон" required>
            <input type="submit" name="submit" value="Оформить">
        </form>
    </section>
<?php endif; ?>

<script defer src="/js/deleteFromCart.js?<?= uniqid(); ?>"></script>
