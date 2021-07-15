<section class="orders">
    <h2>Заказы</h2>
    <table class="orders-table">
        <tr>
            <td>Подробнее</td>
            <td>Имя</td>
            <td>Телефон</td>
            <td>Статус</td>
        </tr>
        <?php foreach ($orders as $order): ?>
            <tr class="order">
                <td><a class="order__link" href="/admin/orderDetails/?id=<?= $order['id'] ?>"><p><?= $order['created_at'] ?></p></a></td>
                <td><p><?= $order['name'] ?></p></td>
                <td><p><?= $order['phone'] ?></p></td>
                <td><p><?= $order['status'] ?></p></td>
            </tr>
        <?php endforeach; ?>
    </table>
</section>


