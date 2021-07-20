<div class="order">
    <h2>Заказ #<?= $order['id'] ?></h2>
    <p>Заказчик: <?= $order['name'] ?></p>
    <p>Телефон: <?= $order['phone'] ?></p>
    <label for="status">Статус: </label>
    <select id="status">
        <?php foreach ($statuses as $status): ?>
            <option <?php if ($status == $order['status']) echo 'selected' ?>><?= $status ?></option>
        <?php endforeach; ?>
    </select>
    <button data-id="<?= $order['id'] ?>" class="change-status-button">Изменить</button>
    <p id="status-response"></p>
    <?php if (!empty($cartGoods)): ?>
        <?php foreach ($cartGoods as $good): ?>
            <div class="cart-good">
                <h4><?= $good['name'] ?></h4>
                <p><?= $good['price'] ?> &#8381;</p>
                <p>Количество: <?= $good['quantity'] ?></p>
                <button class="delete" data-order-id="<?= $order['id'] ?>" data-id="<?= $good['cart_id'] ?>">Удалить</button>
            </div>
        <?php endforeach; ?>
        <p class="total">Итого: <span id="totalAdmin"><?= $total ?></span> &#8381;</p>
    <?php else: ?>
        <p>Заказ #<?= $order['id'] ?> пользователя <?= $order['name'] ?> не содержит товаров</p>
    <?php endif; ?>
</div>

<script defer src="/js/deleteFromAdmin.js?<?= uniqid(); ?>"></script>
<script defer src="/js/sendRequest.js?<?= uniqid(); ?>"></script>
<script defer src="/js/changeStatus.js?<?= uniqid(); ?>"></script>
