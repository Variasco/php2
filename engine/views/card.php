<h2>Товар</h2>
<div>
    <h3><?=$good['name']?></h3>
    <p><?=$good['description']?></p>
    <p>price: <?=$good['price']?></p>
    <button data-id="<?=$good['id']?>" class="buy">Купить</button>
</div>

<script defer src="/js/addToCart.js?<?= uniqid(); ?>"></script>
