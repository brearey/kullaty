<?php
require_once 'db_connect.php';
if (isset($_POST['orderDelete'])) {
	$order = R::load('orders', $_POST['order_id']);
    if (R::trash($order)) {
    	$_SESSION['messages'][0] = "Заказ успешно удален";
    	header('Location: index.php');
    }
    else {
    	$_SESSION['errors'][0] = "Ошибка при удалении";
    	header('Location: index.php');
    }
}
?>