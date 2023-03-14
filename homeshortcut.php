<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="brearey">
    <title>Значок на экран</title>

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

    <!-- Detect.js for parsing Browser data -->
    <script src="libs/detect.min.js"></script>

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
    <?php require_once 'menu.php'; ?>

    <main id="guideChrome" role="main" class="p-4 ml-auto mr-auto" style="max-width: 400px; display: none;">
        <h3 class="text-center">Как добавить значок на главный экран</h3>
        <table>
            <tr class="text-justify">
                <td class="px-2">
                    <p>Чтобы Вы каждый раз не вводили адрес данного сайта рекомендуем создать значок на главный экран Вашего смартфона.</p>
                    <p class="mt-4">Для этого перейдите на страницу <a href="index.php">Заказать воду</a> и откройте меню Chrome (правый верхний угол):</p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/step1.jpg" alt="">
                    
                    <p class="mt-4">Выберите из выпадающего списка пункт <strong>Добавить на главный экран</strong>:</p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/step2.jpg" alt="">

                    <p class="mt-4">По желанию можете изменить название значка, а потом нажмите кнопку <strong>Добавить</strong></p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/step3.jpg" alt="">
                </td>
            </tr>
        </table>
    </main>

    <main id="guideSafari" role="main" class="p-4 ml-auto mr-auto" style="max-width: 400px; display: none;">
        <h3 class="text-center">Как добавить значок на главный экран</h3>
        <table>
            <tr class="text-justify">
                <td class="px-2">
                    <p>Чтобы Вы каждый раз не вводили адрес данного сайта рекомендуем создать значок на главный экран Вашего смартфона.</p>
                    <p class="mt-4">Для этого перейдите на страницу <a href="index.php">Заказать воду</a> и откройте меню Safari (внизу посередине):</p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/safariStep1.jpg" alt="">
                    
                    <p class="mt-4">Найдите в данном меню кнопку <strong>На экран "Домой"</strong> (значок "+"):</p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/safariStep2.jpg" alt="">

                    <p class="mt-4">По желанию можете изменить название значка, а потом нажмите кнопку <strong>Добавить</strong></p>
                    <img class="w-100 rounded-lg border shadow-sm" src="images/safariStep3.jpg" alt="">
                </td>
            </tr>
        </table>
    </main>

    <script>
        var user = detect.parse(navigator.userAgent);
        //var guideChrome = getElementById('guideChrome');
        //var guideSafari = getElementById('guideSafari');

        if (user.browser.family.indexOf('Safari') + 1) {
            $('#guideSafari').show();
        }
        else if (user.browser.family.indexOf('Chrome') + 1) {
            $('#guideChrome').show();
        }
        else {
            $('#guideChrome').show();
        }
    </script>
</body>
</html>
