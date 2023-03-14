<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Страница про компанию</title>
    <meta name="description" content="Страница про компанию">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'public/blocks/header.php' ?>

        <div class="container main">
            <h1>Про компанию</h1>
            <p>Здесь просто текст про компанию</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequatur
                dicta eaque ex illo incidunt iste natus perspiciatis quaerat repudiandae
                vero. Asperiores blanditiis corporis eum neque nobis ratione, sint voluptatibus! Aliquam?</p>

            <?php if (count($data) > 0):?>
                <h1>Есть дополнительный параметр</h1>
                <p>Данные из URL:</p>
            <?php foreach ($data as $el):?>
                <p><?= $el?></p>
            <?php endforeach;?>
            <?php endif;?>


        </div>



    <?php require 'public/blocks/footer.php' ?>
</body>
</html>