<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Корзина товаров</title>
    <meta name="description" content="Корзина товаров">
    <link rel="stylesheet" href="/public/css/main.css" charset="UTF-8">
    <link rel="stylesheet" href="/public/css/products.css" charset="UTF-8">
    <script src="https://kit.fontawesome.com/c2197a4b49.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php require 'public/blocks/header.php' ?>

    <div class="container main">
        <h1>Корзина товаров</h1>
        <?php if (!isset($data['products'])) :?>
            <p class="empty-cart"><?= $data['empty'] ?></p>
        <?php else: ?>
        <a class="del-all" href="/basket/removeAllProducts"><button class="btn btn-del-all">Удалить все товары <img class="trash_bin" src="/public/img/trash_bin.svg"></button></a>
        <div class="products">
            <?php
                $sum = 0;
                for ($i = 0; $i < count($data['products']); $i++):
                    $sum += $data['products'][$i]['price'];
            ?>

                <div class="row row-<?=$data['products'][$i]['id']?>" >
                    <img src="/public/img/<?=$data['products'][$i]['img']?>" alt="<?=$data['products'][$i]['title']?>">
                    <h4><?=$data['products'][$i]['title']?></h4>
                    <span><?=$data['products'][$i]['price']?> $</span>
                    <a class="btn-del-one" href="/basket/removeOneProducts/<?=$data['products'][$i]['id']?>" id="<?=$data['products'][$i]['id']?>-<?=$data['products'][$i]['price']?>"><button class="btn btn-del"><p>Удалить из корзины</p><img class="trash_bin" src="/public/img/trash_one_prod.svg"></button></a>

                </div>
            <?php endfor; ?>
<!--                <button class="btn">Приобрести (<b>--><?php //=$sum?><!-- $</b>)</button>-->
            <?php

            //Секретный ключ интернет-магазина
            $key = "79647146327067366c4c745c685b794f336163456e6b48726d6b59";

            $fields = array();

            // Добавление полей формы в ассоциативный массив
            $fields["WMI_MERCHANT_ID"]    = "114491526124";
            $fields["WMI_PAYMENT_AMOUNT"] = "$sum";
            $fields["WMI_CURRENCY_ID"]    = "643";
            $fields["WMI_PAYMENT_NO"]     = time();
            $fields["WMI_DESCRIPTION"]    = "BASE64:".base64_encode("Покупка товаров на сайте магазина одежджы");
            $fields["WMI_EXPIRED_DATE"]   = date('Y-m-d')."T23:59:59";
            $fields["WMI_SUCCESS_URL"]    = "/success";
            $fields["WMI_FAIL_URL"]       = "/fail";
            $fields["id_of_order"]       = "Value1"; // Дополнительные параметры
//                $fields["WMI_CUSTOMER_PHONE"]       = "Value1"; // Дополнительные параметры

            //Если требуется задать только определенные способы оплаты, раскоментируйте данную строку и перечислите требуемые способы оплаты.
//                $fields["WMI_PTENABLED"]      = array("UnistreamRUB", "SberbankRUB", "RussianPostRUB");

            //Сортировка значений внутри полей
            foreach($fields as $name => $val)
            {
                if(is_array($val))
                {
                    usort($val, "strcasecmp");
                    $fields[$name] = $val;
                }
            }

            // Формирование сообщения, путем объединения значений формы,
            // отсортированных по именам ключей в порядке возрастания.
            uksort($fields, "strcasecmp");
            $fieldValues = "";

            foreach($fields as $value)
            {
                if(is_array($value))
                    foreach($value as $v)
                    {
                        //Конвертация из текущей кодировки (UTF-8)
                        //необходима только если кодировка магазина отлична от Windows-1251
                        $v = iconv("utf-8", "windows-1251", $v);
                        $fieldValues .= $v;
                    }
                else
                {
                    //Конвертация из текущей кодировки (UTF-8)
                    //необходима только если кодировка магазина отлична от Windows-1251
                    $value = iconv("utf-8", "windows-1251", $value);
                    $fieldValues .= $value;
                }
            }

            // Формирование значения параметра WMI_SIGNATURE, путем
            // вычисления отпечатка, сформированного выше сообщения,
            // по алгоритму MD5 и представление его в Base64

            $signature = base64_encode(pack("H*", md5($fieldValues . $key)));

            //Добавление параметра WMI_SIGNATURE в словарь параметров формы

            $fields["WMI_SIGNATURE"] = $signature;

            // Формирование HTML-кода платежной формы

            print "<form action='https://wl.walletone.com/checkout/checkout/Index' method='POST'>";

            foreach($fields as $key => $val)
            {
                if(is_array($val))
                    foreach($val as $value)
                    {
                        print "$key: <input type='text' name='$key' value='$value'/>";
                    }
                else
                    print "<input type='hidden' name='$key' value='$val'/>";
            }

            print "<input type='submit' class='btn btn-buy' value='Приобрести (".$sum.")'></form>";

            ?>
        </div>


        <?php endif; ?>



    </div>


    <?php require 'public/blocks/footer.php' ?>

    <script>
        <?php
        require_once 'app/models/BasketModel.php';
        $basketModel = new BasketModel();
        ?>
        var col = <?= $basketModel->countItems() ?>;

        $(".del-all").click(function() {
            let url = $(this).attr('href');


            col = 0;
            $.ajax({
                url: url,
                type: 'POST',
                cache: false,
                data: {},
                success: function(res) {
                    if(res){

                        $('.basket').html(`Корзина <b>(${col})</b>`);
                        $('.main').html(`<h1>Корзина товаров</h1><p>Корзина пуста</p>`);
                    }
                },
                error: function() {
                    alert('Ошибка добавления в корзину!');
                }
            });

            return false;
        });

        $(".btn-del-one").click(function() {
            let url = $(this).attr('href');
            let temp = $(this).attr('id').split('-');
            let id = temp[0];
            let price = temp[1];
            col--;
            $.ajax({
                url: url,
                type: 'POST',
                cache: false,
                data: {},
                success: function(res) {

                    if(res){

                        $('.basket').html(`Корзина <b>(${col})</b>`);
                        // $(`.row-${id}`).toggle('fast');
                        $(`.row-${id}`).remove();
                        let newPrice = Number($('.btn-buy').val().slice(12, -1)) - Number(price);
                        $('.btn-buy').val(`Приобрести (${newPrice})`);
                        console.log(<?= $sum ?>)
                        <?php

                        ?>
                        if (Number($('.row').length) === 0){
                            $('.basket').html(`Корзина <b>(${col})</b>`);
                            $('.main').html(`<h1>Корзина товаров</h1><p>Корзина пуста</p>`);
                        }

                    }
                    else {

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