<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Главная страница</title>
    <meta name="description" content="Главная страница интернет магазина">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <h1>Популярные товары</h1>
        <div class="products">
            <?php for($i = 0; $i < count($data); $i ++): ?>
                <div class="product">
                    <div class="image">
                        <img src="/public/img/<?=$data[$i]['img']?>" alt="qwe">
                    </div>
                    <h3><?=$data[$i]['title']?></h3>
                    <p><?=$data[$i]['intro']?></p>
                    <a href="/product/<?=$data[$i]['id']?>"><button class="btn">Детальнее</button></a>
                </div>
            <?php endfor; ?>
        </div>
    </div>

    <?php require 'public/blocks/footer.php' ?>

</body>
</html>