<?php
require_once '../libs/rb.php';
require_once '../db_connect.php';

if (isset($_POST['change_status'])) {
	$order  = R::findOne( 'orders', ' hash_phone = ? ', [ $_POST['hash_phone'] ] );
    $order->status = $_POST['change_status'];
    

    if ($_POST['change_status'] == 'Оплачено') {
        $paidOrder = R::dispense('paidorders');
        $paidOrder->hash_phone = $order->hash_phone;
        $paidOrder->count_bottle = $order->count_bottle;
        $paidOrder->payment_method = $order->payment_method;
        $paidOrder->note = $order->note;
        $paidOrder->date = time();

        R::store($paidOrder);
        R::trash($order);
        header('Location: index.php');
    }
    else {
        if (R::store($order)) {
        //$_SESSION['messages'][0] = "Статус изменен";
        header('Location: index.php');
        }
        else {
            $_SESSION['errors'][0] = "При изменении статуса возникла ошибка";
            header('Location: index.php');
        }
    }
}
?>