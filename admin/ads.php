<?php
    require_once '../db_connect.php';
    require_once '../classes/Cookie.php';
    date_default_timezone_set('Asia/Yakutsk');

    if (!isset($_SESSION['logged_user'])) {
        header('Location: login.php');
    }

    if (isset($_POST['ad_add'])) {
        $ad = R::dispense('ads');
        // $ad  = R::findOne( 'ads', ' id = ? ', [ 1 ] );
        $ad->number = 1;
        $ad->text = $_POST['ad_text'];
        $ad->date = time();

        R::store($ad);
    }

    if (isset($_POST['ad_delete']) ) {
        $ad  = R::findOne( 'ads', ' number = ? ', [ 1 ] );
        if (isset($ad)) {
            R::trash($ad);
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="brearey">
    <title>Объявление</title>

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
        <h5 class="text-center">Объявление:</h5>
        <!-- AD VIEW -->
        <?php
        $ad  = R::findOne( 'ads', ' number = ? ', [ 1 ] );
        ?>
        <? if ($ad == NULL): ?>
            <form method="post">
                <table class="ml-auto mr-auto">
                <tr>
                    <td><textarea class="form-control mb-2" name="ad_text" id="" cols="30" rows="10" placeholder="Введите текст объявления" required></textarea></td>
                </tr>
                <tr>
                    <td><input class="btn btn-primary form-control" name="ad_add" type="submit" value="Добавить"></td>
                </tr>
                </table>
            </form>
        <? else: ?>
            <div class="mx-auto p-5">
                <p><?= $ad->text; ?></p>
                <p class="my-2"><small class="text-muted"><?= date("d-m-Y H:i:s", $ad->date); ?></small></p>
                <form action="" method="post">
                    <input class="btn btn-danger mt-2" type="submit" name="ad_delete" value="Удалить">
                </form>
            </div>
        <? endif; ?>
    </main>
    <script>
      
    </script>
</body>
</html>
