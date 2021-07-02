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
        <p class="total">Итого: <span id="total"><?= $total ?></span> &#8381;</p>
    <?php else: ?>
        <p>Корзина пуста</p>
    <?php endif; ?>
</section>

<script defer src="js/deleteFromCart.js?<?= uniqid(); ?>"></script>
