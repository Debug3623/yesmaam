<?php



if(!function_exists('EncryptId')) {

	function EncryptId($id) {

		$id = $id * 4521;

		return base64_encode($id);

	}

}



if(!function_exists('DecryptId')) {

	function DecryptId($id) {

		$id = base64_decode($id);

		return $id / 4521;

	}

}

function twopoints_on_earth($latitudeFrom, $longitudeFrom, $latitudeTo,  $longitudeTo)
{
	$long1 = deg2rad($longitudeFrom);
	$long2 = deg2rad($longitudeTo);
	$lat1 = deg2rad($latitudeFrom);
	$lat2 = deg2rad($latitudeTo);
	
	//Haversine Formula
	$dlong = $long2 - $long1;
	$dlati = $lat2 - $lat1;
	
	$val = pow(sin($dlati/2),2)+cos($lat1)*cos($lat2)*pow(sin($dlong/2),2);
	
	$res = 2 * asin(sqrt($val));
	
	$radius = 3958.756;
	
	return ($res*$radius);
}


function getBidPrice($start_date, $end_date, $time1, $time2, $rate)
{
	$end_date = strtotime($end_date);
	$start_date = strtotime($start_date);
	$datediff = $end_date - $start_date;

	$days = round($datediff / (60 * 60 * 24) + 1) ;

	$time1 = strtotime($time1);
	$time2 = strtotime($time2);
	$difference = round(abs($time2 - $time1) / 3600, 2);
	$hours = $difference;
	//$rate = 60;

	$day_rate = $rate * $hours;
	$total_rate = $day_rate * $days;
	return $total_rate;
}

function getBidPrice2($start_date, $end_date, $rate)
{
	$date1 = $start_date;
  $date2 = $end_date;
  $timestamp1 = strtotime($date1);
  $timestamp2 = strtotime($date2);
  $hours = abs($timestamp2 - $timestamp1) / (60 * 60);
	$day_rate = $rate * $hours;
	return $day_rate;
}