<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Кабинет пользователя</title>
    <meta name="description" content="Кабинет пользователя">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <link rel="stylesheet" href="/public/css/user.css" charset="UTF-8">
    <link rel="stylesheet" href="/public/css/form.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <h1>Кабинет пользователя</h1>
        <div class="user-info">
            <p>Привет, <b><?= $data['name']?></b></p>
            <div class="user_photo" style='background-image: url("/public/img/<?=$data['user_photo']?>")'>
                <img src="/public/img/new_photo.svg" alt="qwe" onclick="changePhoto()">
            </div>
            <div class="error"><?=$data['message'] ?></div>

            <div id="changePhoto">
                <form action="/user/downLoadPhoto" method="post" enctype="multipart/form-data">
                    <button class="btn qqq" type="button">
                    <label for="user_photo" class="input__file-button">Выберите файл</label>
                    </button>
                    <button class="btn" type="submit">Загрузить</button>
                    <button class="btn cancel" type="button">Отмена</button>
                    <input type="file" name="user_photo" id="user_photo">

                </form>
            </div>

            <form action="/user/updateInfo" method="post" class="form-control">
                <h3>О себе:</h3>
                <p class="static_info"><?= $data['about']?></p>
                <textarea cols="40" rows="5" class="info" name="about"><?= $data['about']?></textarea>
                <h3>Адрес доставки:</h3>
                <p class="static_info"><?= $data['address']?></p>
                <input type="text" value="<?= $data['address']?>" class="info" name="address">
                <h3>Номер телефона:</h3>
                <p class="static_info"><?= $data['tel']?></p>
                <input type="tel" value="<?= $data['tel']?>" class="info" name="tel">
                <button class="btn change_info" type="button">Изменить</button>
                <button class="btn save_change" type="submit" style="display: none">Сохранить</button>
            </form>








            <form action="/user/dashboard" method="post">
                <input type="hidden" name="exit_btn">
                <button class="btn" type="submit">Выйти</button>
            </form>

        </div>

    </div>



    <?php require 'public/blocks/footer.php' ?>
</body>
</html>

<script>

    // document.onload = function () {
    //     $('.info').hide()
    // }

    $('.info').on('input keyup', function() {
        $('.save_change').show()
    })

    $('.change_info').click(function () {
        if ($('.info').is(':visible')){
            $('.info').hide()
            $('.static_info').show()
            $('.change_info').html('Изменить')
            $('.save_change').hide()
        }
        else {
            $('.info').show()
            $('.static_info').hide()
            $('.change_info').html('Отменить')

        }

    })


    function changePhoto() {
        $('#changePhoto').show()
    }

    $('.cancel').click(function () {
        $('#changePhoto').hide()
    })


    let uploadField = document.getElementById("user_photo");

    uploadField.onchange = function() {
        if(this.files[0].size > 524288){
            alert("File is too big!");
            this.value = "";
        };
    };
</script>