<?php
    require_once 'db_connect.php';

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
    <title>Справка</title>

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
    <div id="copiedMessage" class="alert alert-success m-2" role="alert" style="display: none !important;">
        Телефонный номер скопирован в буфер обмена.
    </div>
    <main role="main" class="p-4 ml-auto mr-auto" style="max-width: 400px;">
        <table>
            <tr>
                <td class="px-2">
                    <div class="text-center">
                        <p>
                            <a style="font-size: 1.2rem;" class="text-success" href="https://wa.me/79246628934">Написать диспетчеру <i class="fab fa-whatsapp"></i></a>
                        </p>
                    </div>
                    <div class="mt-4 text-center">
                        <p>
                            <a style="font-size: 1.2rem;" class="text-primary" href="tel: +79246628934">Позвонить диспетчеру <i class="fas fa-phone"></i></a>
                        </p>
                    </div>
                </td>
            </tr>
            <tr class="text-justify">
                <td class="px-2">
                    <hr>
                    <h5>Мобильный банк</h5>
                    <p>Отправляете через Мобильный банк Сбербанк на телефонный номер: <strong id="phone">89246628934 </strong><button class="btn btn-outline-secondary btn-sm" onclick="copyPhone()">Копировать номер</button></p>
                </td>
            </tr>
            <tr class="text-justify">
                <td class="px-2">
                    <hr>
                    <p>
                        Мы всегда будем рады видеть Вас по адресу: <strong>📍c. Чапаево, ул.Школьная 13</strong>
                        <br>
                        <br>
                        Прайс услуг в обычные дни:
                        <ul>
                            <li>
                                🚀 доставка на дом (обмен)-<?= $price->value ?>₽
                            </li>
                            <li>
                                🚗 самовывоз (разлив)-90₽
                            </li>
                            <li>
                                💧доставка+новая тара с чистой водой 900₽
                            </li>
                        </ul>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <hr>
                    <h5>Мы на карте</h5>
                    <? include_once 'map.php'; ?>
                </td>
            </tr>
        </table>

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
    </main><!-- /.container -->
</body>
</html>
