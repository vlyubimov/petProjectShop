<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $data['title'] ?></title>
    <meta name="description" content="<?= $data['title']?>">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <h1><?= $data['title']?></h1>
        <div class="products">
            <?php for($i = (isset($data['page']) ? ($data['page']-1)*3 : 0); $i < (isset($data['page']) ? $data['page']*3 : count($data['products'])); $i ++): ?>
            <?php if (!isset($data['products'][$i]))
                continue
                ?>


                <div class="product">
                    <div class="image">
                        <img src="/public/img/<?=$data['products'][$i]['img']?>" alt="qwe">
                    </div>
                    <h3><?=$data['products'][$i]['title']?></h3>
                    <p><?=$data['products'][$i]['intro']?></p>
                    <a href="/product/<?=$data['products'][$i]['id']?>"><button class="btn">Детальнее</button></a>
                </div>
            <?php endfor; ?>
        </div>
        <?php if(count($data['products']) > 3): ?>
        <?php for($i = 0; $i < ceil(count($data['products'])/3); $i ++): ?>
            <?php if ($data['page']-1 == $i):?>
                <button class="btn pagination current"><?=$i+1?></button>
            <?php else: ?>
                <a href="/categories/<?= isset($data['category']) ? $data['category'].'/':'' ?>page<?=$i+1?>"><button class="btn pagination <?= $data['page']-1 == $i ? 'current' : ''?>"><?=$i+1?></button></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php endif; ?>


<!--        <div class="products">-->
<!--            --><?php //for($i = 0; $i < count($data['products']); $i ++): ?>
<!--                <div class="product">-->
<!--                    <div class="image">-->
<!--                        <img src="/public/img/--><?php //=$data['products'][$i]['img']?><!--" alt="qwe">-->
<!--                    </div>-->
<!--                    <h3>--><?php //=$data['products'][$i]['title']?><!--</h3>-->
<!--                    <p>--><?php //=$data['products'][$i]['intro']?><!--</p>-->
<!--                    <a href="/product/--><?php //=$data['products'][$i]['id']?><!--"><button class="btn">Детальнее</button></a>-->
<!--                </div>-->
<!--            --><?php //endfor; ?>
<!--        </div>-->
<!--        --><?php //if($data['count'] > 3): ?>
<!--            --><?php //for($i = 0; $i < (int)($data['count']/3); $i ++): ?>
<!--                --><?php //if ($data['page']-1 == $i):?>
<!--                    <button class="btn pagination current">--><?php //=$i+1?><!--</button>-->
<!--                --><?php //else: ?>
<!--                    <a href="/categories/--><?php //= isset($data['category']) ? $data['category'].'/':'' ?><!----><?php //=$i+1?><!--"><button class="btn pagination --><?php //= $data['page']-1 == $i ? 'current' : ''?><!--">--><?php //=$i+1?><!--</button></a>-->
<!--                --><?php //endif; ?>
<!--            --><?php //endfor; ?>
<!--        --><?php //endif; ?>
    </div>


    <?php require 'public/blocks/footer.php' ?>
</body>
</html>