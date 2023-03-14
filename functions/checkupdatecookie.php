<?php
function checkUpdateCookie($phone, $address, $expiry) {
		$hashPhone = md5($phone);

		if (!Cookie::exists('hashPhone')) {
		    Cookie::put('hashPhone', $hashPhone, $expiry);
		}
		else {
		    if ($hashPhone == md5(Cookie::get('hashPhone'))) {
		        Cookie::put('hashPhone', Cookie::get('hashPhone'), $expiry);
		        echo Cookie::get('hashPhone');
		    }
		    else {
		        Cookie::put('hashPhone', $hashPhone, $expiry);
		    }
		}
		Cookie::put('phone', $phone, $expiry);
		Cookie::put('address', $address, $expiry);

		return $hashPhone;
	}

?>