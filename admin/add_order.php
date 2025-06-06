<?php
    require_once '../db_connect.php';
    require_once '../classes/Cookie.php';
    date_default_timezone_set('Asia/Yakutsk');

    if (!isset($_SESSION['logged_user'])) {
        header('Location: login.php');
    }

    if (isset($_POST['add_order'])) {
        $hash_phone = md5($_POST['phone']);
        //Отправляем данные о пользователе в БД
        $user  = R::findOne( 'users', ' hash_phone = ? ', [ $hashPhone ] );
        if (!isset($user)) { $user = R::dispense('users'); }
        $user->hash_phone = $hashPhone;
        $user->phone = $_POST['phone'];
        $user->address = $_POST['address'];
        $user->order_created = true;
        R::store( $user );
        $order = R::dispense('orders');
        $order->hash_phone = md5($_POST['phone']);
        $order->count_bottle = $_POST['count_bottle'];
        $order->payment_method = $_POST['payment_method'];
        $order->note = $_POST['note'];
        $order->status = 'В ожидании';
        $order->date = time();
        R::store( $order );
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="brearey">
    <title>Добавить заказ вручную</title>

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
        <h5 class="text-center">Добавить заказ вручную</h5>
        <!-- ADD ORDER FORM -->
        <form method="post">
    <table class="ml-auto mr-auto">
        <tr>
            <td>
                <input id="phone" name="phone" class="form-control" type="tel" placeholder="79246628934" required pattern="7[0-9]{10}">
            </td>
        </tr>
        <tr>
            <td>
                <label for="address" class="mt-2">Введите адрес*</label>
                <input name="address" class="form-control" type="text" placeholder="ул. Каландарашвили 17" required>
            </td>
        </tr>
        <tr>
            <td>
                <input class="form-control mb-2" type="number" name="count_bottle" placeholder="Количество бутылок" required>
            </td>
        </tr>
        <tr>
            <td>
                <label for="payment_method" class="mt-2">Выберите способ оплаты*</label>
                <select class="form-control mb-2" name="payment_method" required>
                    <option value="Мобильный банк">Мобильный банк</option>
                    <option value="Наличными">Оплата наличными</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <textarea class="form-control mb-2" name="note" cols="30" rows="5" placeholder="Примечание"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <input class="btn btn-primary form-control" name="add_order" type="submit" value="Добавить заказ">
            </td>
        </tr>
    </table>
</form>
    </main>
    <script>
      
    </script>
</body>
</html>
