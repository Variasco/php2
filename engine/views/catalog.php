<h2>Каталог</h2>

<?php foreach ($catalog as $item): ?>
    <div>
        <h3><a href="/?c=product&a=card&id=<?= $item['id'] ?>"><?= $item['name'] ?></a></h3>
        <img src="product_img/<?= $item['picture'] ?>" alt="<?= $item['picture'] ?>">
        <p>price: <?= $item['price'] ?></p>
        <button>Купить</button>
    </div>
<?php endforeach; ?>

<button href="/?c=product&page=<?= $page ?>" id="more">Еще</button>

<script defer src="js/paginator.js"></script>
