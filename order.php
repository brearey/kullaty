<?php
	require_once 'db_connect.php';

	require_once 'classes/Cookie.php';
	require_once 'classes/Validation.php';
	require_once 'classes/sanitize.php';

	require_once 'functions/checkupdatecookie.php';

	$expiry = 86400 * 30;

	if (isset($_POST['make_order']))
	{
		$data = $_POST;

		$validate = new Validation;
		$validation = $validate->check($data, array(
			'phone' => array(
	            'name' => 'Телефон',
	            'required' => true,
	            'min' => 10,
	            'max' => 11
	        ),
	        'address' => array(
	            'name' => 'Адрес',
	            'required' => true
	        ),
	        'countBottle' => array(
	        	'name' => 'Количество бутылей',
	        	'required' => true
	        )
		));

		if($validation->passed())
	    {
	    	$phone = str_replace('+','',$data['phone']);
			$phone = str_replace(' ','',$phone);
			$phone = str_replace('(','',$phone);
			$phone = str_replace(')','',$phone);
			$phone = str_replace('-','',$phone);
			if ($phone[0] == "8") {
				$phone = substr_replace($phone, "7", 0, 1);
			}
			if ($phone[0] == "9" && strlen($phone) == 10) {
				$phone = "7" . $phone;
			}
			//Проверяем и обновляем Cookie
			$hashPhone = checkUpdateCookie($phone, $data['address'], $expiry);
			Cookie::put('orderCreated', true, $expiry);
			//Отправляем данные о пользователе в БД
			$user  = R::findOne( 'users', ' hash_phone = ? ', [ $hashPhone ] );
			if (!isset($user)) { $user = R::dispense('users'); }
			$user->hash_phone = $hashPhone;
			$user->phone = $phone;
			$user->address = $data['address'];
			$user->order_created = true;
			R::store( $user );

			$order = R::dispense('orders');
			$order->hash_phone = $hashPhone;
			$order->count_bottle = $data['countBottle'];
			$order->payment_method = $data['paymentMethod'];
			$order->note = $data['note'];
			$order->status = 'В ожидании';
			$order->date = time();
			R::store( $order );

			header('Location: orderStatus.php');
	    }   
	    else
	    {
	        $_SESSION['errors'] = $validation->errors();
	        header('Location: index.php');
	    }
	}
	else
	{
		$_SESSION['errors'][0] = "Заполните поля и нажмите кнопку Сделать заказ";
		header('Location: index.php');
	}
?>