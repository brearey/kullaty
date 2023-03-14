<?php
  require_once '../db_connect.php';
  require_once '../classes/Cookie.php';
  $expiry = 86400 * 30;

  if (isset($_SESSION['logged_user'])) {
    header('Location: index.php');
  }

  if (isset($_POST['do_login'])) {
    $admin = R::findOne( 'admins', ' login = ? ', [ $_POST['login'] ] );
    if (isset($admin)) {
      if ($admin->password == md5($_POST['password'])) {
        $_SESSION['logged_user'] = $admin;
        Cookie::put('login', $_POST['login'], $expiry);
        Cookie::put('password', md5($_POST['password']), $expiry);
        header('Location: index.php');
      }

    }
    /*$admin = R::dispense('admins');
    $admin->login = $_POST['login'];
    $admin->password = md5($_POST['password']);
    R::store($admin);*/
  }
?>
<!DOCTYPE html>
<html lang="ru">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../images/favicon.ico">

    <title>Вход в админку</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <!-- Custom styles for this template -->
    <link href="../css/login.css" rel="stylesheet">
  </head>

  <body class="text-center">
    <form class="form-signin" method="post">
      <img class="mb-4" src="../images/180x180.png" alt="" width="72" height="72">
      <h1 class="h3 mb-3 font-weight-normal">Вход в панель управления:</h1>
      <label for="inputLogin" class="sr-only">Логин</label>
      <input type="login" id="inputLogin" class="form-control mb-2" placeholder="логин" required autofocus name="login" value="<? if (Cookie::exists('login')){echo Cookie::get('login');} ?>">
      <label for="inputPassword" class="sr-only">Пароль</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="пароль" required name="password" >
      <button class="btn btn-lg btn-primary btn-block" type="submit" name="do_login">Войти</button>
      <p class="mt-5 mb-3 text-muted">&copy; Куллаты 2020</p>
    </form>
  </body>
</html>
