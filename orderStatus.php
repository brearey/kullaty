<?php
require_once 'db_connect.php';
require_once 'classes/Cookie.php';
require_once 'classes/Validation.php';
require_once 'classes/sanitize.php';

date_default_timezone_set('Asia/Yakutsk');
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="brearey">
    <title>Cтатус заказа</title>

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
    <?php require_once("menu.php") ?>

    <main role="main" class="p-4 ml-auto mr-auto" style="max-width: 400px;">
        <h5 class="text-center">Ваш заказ:</h5>
            <?php
                if (Cookie::exists('hashPhone')) {
                    $hashPhone = Cookie::get('hashPhone');
                    $user  = R::findOne('users', 'hash_phone = ?', [ $hashPhone ]);
                    $order = R::findOne('orders', 'hash_phone = ?', [ $hashPhone ]);
                    if ($order->status != 'В ожидании') {
                        $disabled = 'disabled';
                    }
                    else {
                        $disabled = '';
                    }

                    if ($order->status == 'Доставлено') {
                        echo '
                            <div class="alert alert-primary" role="alert">
                                Пожалуйста сделайте оплату заказа, как только диспетчер примет оплату данный заказ будет удален автоматически.
                            </div>';
                    }

                    if (isset($order) && $order->status != 'Оплачено'): ?>
                        <div>
                            <ul class="list-group list-group-flush">
                                <!-- <li class="list-group-item">Номер вашего заказа: <?= $order->id; ?></li> -->
                                <li class="list-group-item">Количество бутылей: <?= $order->count_bottle; ?></li>
                                <li class="list-group-item">Способ оплаты: <?= $order->payment_method; ?></li>
                                <li class="list-group-item">Сумма оплаты: <?= $order->count_bottle * 100; ?> рублей</li>
                                <li class="list-group-item"><strong>Статус заказа: <?= $order->status; ?></strong></li>
                                <li class="list-group-item text-justify">Ваше пожелание: <i><?= $order->note; ?></i></li>
                                <li class="list-group-item text-secondary text-center" style="font-size: 0.8rem;"><?= date("d-m-Y H:i:s", $order->date); ?></li>
                            </ul>
                            <div class="text-center">
                                <button class="btn btn-outline-success" onclick="document.location.reload(true)">Обновить статус</button>
                            </div>
                            <div class="text-center">
                                <form action="orderDelete.php" method="post">
                                    <input type="hidden" name="order_id" value="<?= $order->id; ?>">
                                    <button class="btn btn-outline-danger mt-4" name="orderDelete" type="submit" onclick="return confirm('Вы точно хотите удалить заказ?')" <?= $disabled; ?>>Отменить заказ</button>
                                </form>
                            </div>
                            <? if ($order->payment_method == "Мобильный банк"): ?>
                            <div class="my-5">
                                <h5>Мобильный банк</h5>
                                <p>Отправляете через Мобильный банк Сбербанк на телефонный номер: <strong id="phone">89246628934 </strong><button class="btn btn-outline-secondary btn-sm" onclick="copyPhone()">Копировать номер</button></p>
                            </div>
                            <? endif; ?>
                        </div>
                    <? else: ?>
                        <div class="px-2 text-center">
                            <p class="text-secondary">Пока у вас нет заказов</p>
                            <p><a href="index.php">Сделать заказ</a></p>
                        </div>
                    <? endif; ?>
                <?php } else {
                    echo '
                        <div class="px-2 text-center">
                            <p class="text-secondary">Пока у вас нет заказов</p>
                            <p><a href="index.php">Сделать заказ</a></p>
                        </div>';
                } ?>
    </main><!-- /.container -->
    <script>
        function copyPhone() {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val("89246628934").select();
            document.execCommand("copy");
            //alert("Телефонный номер скопирован в буфер обмена.");
            $("#copiedMessage").show();
            $temp.remove();
        }
    </script>
</body>
</html>
