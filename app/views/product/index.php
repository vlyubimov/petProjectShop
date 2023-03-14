<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['title']?></title>
    <meta name="description" content="<?= $data['title']?>">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <link rel="stylesheet" href="/public/css/product.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
<?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <a href="/categories/<?= $data['category']?>"><button class="btn">Назад</button></a>
        <h1><?= $data['title']?></h1>
        <div class="info">
            <div>
                <img src="/public/img/<?= $data['img']?>" alt="<?= $data['title']?>">
            </div>
            <div>
                <p><?= $data['intro']?></p>
                <p><?= $data['text']?></p>
            </div>
            <div>
<!--                <form action="/basket" method="post">-->
<!--                    <input type="hidden" name="item_id" value="--><?php //= $data['id'] ?><!--">-->
<!--                    <button class="btn">Купить за --><?php //= $data['price'] ?><!--$</button>-->
<!--                </form>-->
                <a class="buyItem" href="/basket", id="<?= $data['id'] ?>"><button class="btn" onclick="">Купить за <?= $data['price'] ?>$</button></a>

            </div>
        </div>
    </div>


<?php require 'public/blocks/footer.php' ?>

<script>
    <?php
    require_once 'app/models/BasketModel.php';
    $basketModel = new BasketModel();
    ?>
    var col = <?= $basketModel->countItems() ?>;

    $(".buyItem").click(function() {
        let url = $(this).attr('href');
        let item_id = $(this).attr('id');

        col++;
        $.ajax({
            url: url,
            type: 'POST',
            cache: false,
            data: {item_id: item_id},
            success: function(res) {
                if(res){
                    $('.basket').html(`Корзина <b>(${col})</b>`);
                }
            },
            error: function() {
                alert('Ошибка добавления в корзину!');
            }
        });
        return false;
    });

</script>
</body>
</html>

