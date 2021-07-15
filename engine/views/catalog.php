<h2>Каталог</h2>
<section class="catalog">
    <?php foreach ($catalog as $item): ?>
        <div class="catalog-item">
            <h3><a href="/product/card/?id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h3>
            <img src="product_img/<?= $item['picture'] ?>" alt="<?= $item['picture'] ?>">
            <p>price: <?= $item['price'] ?></p>
            <button data-id="<?=$item['id']?>" class="buy">Купить</button>
        </div>
    <?php endforeach; ?>
</section>

<script defer src="/js/paginator.js?<?= uniqid(); ?>"></script>
<script defer src="/js/addToCart.js?<?= uniqid(); ?>"></script>
