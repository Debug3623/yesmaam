<?php

namespace App\Libraries;

class Sms {
	public function sendOTP($data)
	{
		$curl = curl_init();

		curl_setopt_array($curl, [
		     CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"631ee2ca54dca557795627c8\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n  \"mobiles\": \"{$data['phone']}\",\n  \"name\": \"{$data['name']}\",\n  \"code\": \"{$data['code']}\"\n}",
			CURLOPT_HTTPHEADER => [
			"authkey: 379253AvZ7n11BvS762c6899eP1",
			"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}



	public function approvedEmployee($data)
	{
		$curl = curl_init();

		curl_setopt_array($curl, [
		     CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"644e5c2ad6fc05734b2b1a53\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n  \"mobiles\": \"{$data['phone']}\",\n  \"name\": \"{$data['name']}\"}",
			CURLOPT_HTTPHEADER => [
			"authkey: 379253AvZ7n11BvS762c6899eP1",
			"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}


	public function booking($data)
	{
		$curl = curl_init();

		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"638786056b73da65bc38d033\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n  \"mobiles\": \"{$data['phone']}\"\n}",
			CURLOPT_HTTPHEADER => [
			"authkey: 379253AvZ7n11BvS762c6899eP1",
			"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}

	public function babysittingCustomer($data)
	{
		$curl = curl_init();
		//Dear Customer, you have successfully hired ##babysitter## ##nursename## from ##from## to ##to## dated ##bookingdate##. Thank you for booking the service at Yes! maam. For further details Please check the service history.
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"638789b25189b84df9634ad3\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n \"mobiles\": \"{$data['phone']}\",\n  \"babysitter\": \"{$data['babysitter']}\",\n \"nursename\": \"{$data['nursename']}\",\n \"from\": \"{$data['from']}\",\n \"to\": \"{$data['to']}\",\n \"bookingdate\": \"{$data['bookingdate']}\"\n}",
			CURLOPT_HTTPHEADER => [
				"authkey: 379253AvZ7n11BvS762c6899eP1",
				"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}

	public function babysittingNurse($data)
	{
		$curl = curl_init();
		//Dear Babysitter, ##babysitter## ##nursename## you have been successfully hired from ##from## to ##to## dated ##bookingdate##. Thank you for booking the service at Yes! maam. For further details Please check the service history.
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"63878aa2a08bab679b53c965\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n \"mobiles\": \"{$data['phone']}\",\n  \"babysitter\": \"{$data['babysitter']}\",\n \"nursename\": \"{$data['nursename']}\",\n \"from\": \"{$data['from']}\",\n \"to\": \"{$data['to']}\",\n \"bookingdate\": \"{$data['bookingdate']}\",\n \"area\": \"{$data['area']}\"\n}",
			CURLOPT_HTTPHEADER => [
				"authkey: 379253AvZ7n11BvS762c6899eP1",
				"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}

	public function caregiverCustomer($data)
	{
		$curl = curl_init();
		//Dear Customer, you have successfully hired ##caregiver## ##nursename## from ##from## to ##to## dated ##bookingdate##. Service Time ##time## Duration ##hour##. Thank you for booking the service at Yes! maam. For further details Please check the service history.
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"638b8663aa1fdb213d2180d4\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n \"mobiles\": \"{$data['phone']}\",\n \"nursename\": \"{$data['nursename']}\",\n \"from\": \"{$data['from']}\",\n \"to\": \"{$data['to']}\",\n \"bookingdate\": \"{$data['bookingdate']}\",\n \"caregiver\": \"{$data['caregiver']}\",\n \"time\": \"{$data['time']}\",\n \"hour\": \"{$data['hour']}\"\n }",
			CURLOPT_HTTPHEADER => [
				"authkey: 379253AvZ7n11BvS762c6899eP1",
				"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}

	public function caregiverNurse($data)
	{
		$curl = curl_init();
		//Dear Caregiver, ##caregiver## ##nursename## you have been successfully hired from ##from## to ##to## dated ##bookingdate##. Service Time ##time## Duration ##hour## Customer Address is ##address##. Thank you for booking the service at Yes! maam. For further details Please check the service history.
		curl_setopt_array($curl, [
			CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"638b86f580818b61be12e063\",\n  \"sender\": \"YESMAAM\",\n  \"short_url\": \"0\",\n \"mobiles\": \"{$data['phone']}\",\n \"nursename\": \"{$data['nursename']}\",\n \"from\": \"{$data['from']}\",\n \"to\": \"{$data['to']}\",\n \"bookingdate\": \"{$data['bookingdate']}\",\n \"caregiver\": \"{$data['caregiver']}\",\n \"time\": \"{$data['time']}\",\n \"hour\": \"{$data['hour']}\",\n \"address\": \"{$data['address']}\"\n }",
			CURLOPT_HTTPHEADER => [
				"authkey: 379253AvZ7n11BvS762c6899eP1",
				"content-type: application/JSON"
			],
		]);

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
  			return "cURL Error #:" . $err;
		} else {
  			return $response;
		}
	}
}