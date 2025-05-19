<?php
    require_once 'db_connect.php';
    require_once 'classes/Cookie.php';

    // Get price
    $price  = R::findOne( 'system_info', ' name = ? ', [ 'price' ] );
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="brearey">
    <title>Заказать воду</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Favicons and icons -->
    <link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="images/57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="images/60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="images/72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="images/76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="images/114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="images/120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="images/144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="images/152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="images/180x180.png">
    <meta name="theme-color" content="#21897E">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="libs/fontawesome/css/all.css">
    <!-- Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

    <style>
        p {
            margin: 0;
        }
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
            font-size: 3.5rem;
            }
        }

        body {
            padding-top: 5rem;
        }

        .bottleCount {
            font-size: 2rem;
        }

        .addInfo {
            font-size: 1rem;
        }

    </style>
</head>
<body>
    <? require_once 'menu.php'; ?>
    <!-- CONTENT -->
    <main role="main" class="p-4">
        <!-- Вывод объявлений -->
        <? $ad  = R::findOne( 'ads', ' number = ? ', [ 1 ] ); ?>
        <? if (isset($ad)): ?>
            <div class="alert alert-warning" role="alert">
                <p><?= $ad->text; ?></p>
            </div>
        <? endif;?>

        <?
        if (Cookie::exists('hashPhone')) {
            $hashPhone = Cookie::get('hashPhone');
            $order = R::findOne('orders', 'hash_phone = ?', [ $hashPhone ]);
            if (isset($order)) {
                $disabled = 'disabled';
                echo '
                <div class="alert alert-primary" role="alert">
                    У вас есть <a href="orderStatus.php">активный заказ</a>.
                </div>';
            }
            else {
                $disabled = '';
            }
        }
        ?>
        <!-- Вывод ошибок -->
        <? if (isset($_SESSION['errors'])): ?>
            <div class="alert alert-danger" role="alert">
                <ul>
                    <? foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= $error; ?></li>
                    <? endforeach; ?>
                </ul>
            </div>
        <? unset($_SESSION['errors']); ?>
        <? endif;?>

        <!-- Вывод сообщений -->
        <? if (isset($_SESSION['messages'])): ?>
            <div class="alert alert-success" role="alert">
                <ul>
                    <? foreach ($_SESSION['messages'] as $message): ?>
                        <li><?= $message; ?></li>
                    <? endforeach; ?>
                </ul>
            </div>
        <? unset($_SESSION['messages']); ?>
        <? endif;?>

        <form action="order.php" method="post" class="form-group">
        <table class="ml-auto mr-auto">
            <tr class="bottleCount text-center">
                <td class="px-4">
                    <img src="images/bottle.jpg" alt="<?= $price->value ?> руб/шт." height="200" title="<?= $price->value ?> руб/шт.">
                </td>
                <td class="pl-4">
                   <div>
                        <div>
                            <i class="text-primary fas fa-plus-square" onclick="changeBottle(1)"></i>
                        </div>
                        <div>
                            <input id="countBottle" style="max-width: 80px; font-size: 1.4rem;" class="form-control text-center" type="number" name="countBottle" value="1" onchange="valueBan()" required>
                        </div>
                        <div>
                            <i class="text-primary fas fa-minus-square" onclick="changeBottle(-1)"></i>
                        </div>
                    </div> 
                </td>
            </tr>
            <tr class="addInfo">
                <td colspan="2">
                        <div class="price mt-2 text-center text-success" style="font-size: 1.2rem;">
                            <b>Итого: <i class="fas fa-ruble-sign"></i> <span id="price"><?= $price->value ?></span></b>
                        </div>
                        <label for="phone" class="mt-2">Введите ваш телефон*</label>
                        <input id="phone" name="phone" class="form-control" type="tel" placeholder="79246628934" value="<? if (Cookie::exists('phone')){echo Cookie::get('phone');} ?>" required pattern="7[0-9]{10}">

                        <label for="address" class="mt-2">Введите ваш адрес*</label>
                        <input name="address" class="form-control" type="text" placeholder="ул. Каландарашвили 17" value="<? if (Cookie::exists('address')){ echo Cookie::get('address');} ?>" required>

                        <label for="paymentMethod" class="mt-2">Выберите способ оплаты*</label>
                        <select class="form-control" name="paymentMethod" required>
                            <option value="">Не выбрано</option>
                            <option value="Мобильный банк">Мобильный банк</option>
                            <option value="Наличными">Оплата наличными</option>
                        </select>

                        <label for="note" class="mt-2">Введите ваши пожелания:</label>
                        <textarea class="form-control" name="note" rows="6" placeholder="Например, оставьте в подъезде"></textarea>

                        <input <?= $disabled ?> class="form-control btn btn-success mt-4" type="submit" value="Сделать заказ" name="make_order">
                </td>   
            </tr>
        </table>
        </form>
        <div class="text-secondary">
            <p>* - обязательные поля</p>
        </div>
    </main>
    <script>
        var priceOne = <?= $price->value ?>;
        var countBottle = document.getElementById("countBottle");
        var price = document.getElementById("price");
        
        function changeBottle(count) {
            if (countBottle.value == "") {
                countBottle.value = 1;
                price.textContent = parseInt(countBottle.value) * priceOne;
            }
            else {
                countBottle.value = parseInt(countBottle.value) + parseInt(count);
                price.textContent = parseInt(countBottle.value) * priceOne;

                if (parseInt(countBottle.value) < 1) {
                countBottle.value = 1;
                price.textContent = parseInt(countBottle.value) * priceOne;
                }
            }
        }

        function valueBan() {
            if (countBottle.value != "") {
                if (parseInt(countBottle.value) < 1) {
                    countBottle.value = 1;
                    price.textContent = parseInt(countBottle.value) * priceOne;
                }
                price.textContent = parseInt(countBottle.value) * priceOne;
            }
        }
        $(document).ready ( function(){
            price.textContent = parseInt(countBottle.value) * priceOne;
        });
    </script>
</body>
</html>
