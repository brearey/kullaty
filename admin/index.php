<?php
    require_once '../db_connect.php';
    require_once '../classes/Cookie.php';
    date_default_timezone_set('Asia/Yakutsk');

    if (!isset($_SESSION['logged_user'])) {
        header('Location: login.php');
    }
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
    <title>Админка</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.4/examples/starter-template/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Favicons and icons -->
    <link rel="shortcut icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="icon" href="../images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" sizes="57x57" href="../images/57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="../images/60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="../images/72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="../images/76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="../images/114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="../images/120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="../images/144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="../images/152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="../images/180x180.png">
    <meta name="theme-color" content="#21897E">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="../libs/fontawesome/css/all.css">
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

    </style>
</head>
<body>
    <? require_once 'admin_menu.php'; ?>
    <main role="main" class="p-2">
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
        <!-- CONTENT -->
        <h5 class="text-center">Активные заказы:</h5>
        <!-- ORDERS LIST -->
        <?php
        $orders = R::findAll('orders', ' ORDER BY date DESC ' );
        ?>
        <? foreach ($orders as $order): ?>
                <?php
                    $user  = R::findOne( 'users', ' hash_phone = ? ', [ $order->hash_phone ] );
                ?>

                <div class="card mb-2 bg-light <? if ($order->status == 'В ожидании') {echo 'border-warning';} else { echo 'border-primary';} ?>">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-9">
                                <h5 class="card-title"><?= $user->address; ?></h5>
                                <h5 class="card-subtitle"><a href="tel:+<?=$user->phone;?>"><?= $user->phone; ?></a></h5>
                            </div>
                            <div class="col-3 text-center">
                                <h6 class="card-text text-muted"><span style="font-size: 1.4rem;"><?= $order->count_bottle; ?></span><span> шт.</span></h6>
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample<?=$order->id;?>">
                            <p class="card-text">Номер заказа: <strong><?= $order->id; ?></strong></p>
                            <p class="card-text">Сумма оплаты: <strong><?= $order->count_bottle * $price->value; ?> рублей</strong></p>
                            <p class="card-text">Способ оплаты: <?= $order->payment_method; ?></p>
                            <p class="card-text">Пожелание заказчика: <i class="text-muted"><?
                                if ($order->note == "") {echo 'нет';} else { echo $order->note;}
                            ?></i></p>
                            <form action="changeStatus.php" method="post">
                                <input type="hidden" name="hash_phone" value="<?=$order->hash_phone;?>">
                                <select class="custom-select" name="change_status" onchange="this.form.submit()">
                                    <option value="В ожидании" <? if ($order->status == 'В ожидании') echo "selected";?>>В ожидании</option>
                                    <option value="Принят" <? if ($order->status == 'Принят') echo "selected";?>>Принят</option>
                                    <option value="В пути" <? if ($order->status == 'В пути') echo "selected";?>>В пути</option>
                                    <option value="Доставлено" <? if ($order->status == 'Доставлено') echo "selected";?>>Доставлено</option>
                                </select>
                            </form>
                            <p class="card-text text-center mb-2"><small class="text-muted"><?= date("d-m-Y H:i:s", $order->date); ?></small></p>
                            <form action="changeStatus.php" method="post" class="text-right">
                                <input type="hidden" name="hash_phone" value="<?=$order->hash_phone;?>">
                                <button type="submit" name="change_status" value="Оплачено" class="btn btn-sm btn-outline-success" onclick="return confirm('Вы уверены? Данный заказ перейдет в раздел оплаченные')">Оплачено?</button>
                            </form>
                        </div>
                        <div class="text-center mt-1">
                            <a class="card-link" data-toggle="collapse" href="#collapseExample<?=$order->id;?>" role="button" aria-expanded="false" aria-controls="collapseExample<?=$order->id;?>">Подробнее</a>
                        </div>
                    </div>
                </div>
        <? endforeach; ?>
    </main>
    <script>
      
    </script>
</body>
</html>
