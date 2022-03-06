<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5"></div>
		<div class="col-md-2">
			<form action="" method="post">
				<input type="number" name="mobilenum" class="mt-2 form-control" placeholder="Enter Your mobilenum Id" />
				<input type="submit" name="submit" class="mt-2 form-control"/>
			</form>
		</div>
	</div>
</div>
<?php 
if ( isset( $_POST['submit'] ) ) {
$mobilenum = $_POST['mobilenum'];
setcookie('myNum', $mobilenum);
$res = sendOtp($mobilenum);
// print_r($res);
if ($res['status'] == 'pending') { ?>
<div class="container-fluid">
	<div class="row">
		<div class="col-md-5"></div>
		<div class="col-md-2">
			<form action="" method="post">
				<input type="number" name="otp" placeholder="Enter Your OTP Id" /><br></br>
				<input type="submit" name="submit1" style="width: 11%;" />
			</form>
		</div>
	</div>
</div>
<?php
}
}
if ( isset( $_POST['submit1'] ) ) { 
$res1 = verifyOtp($_COOKIE['myNum'],$_POST['otp'] );
// Array ( [otp] => 4375 [submit1] => Submit )
  print_r($res1);
  print_r($_COOKIE['myNum']);
}
// verify otp 
function verifyOtp($mobilenum, $otp){

	$curl = curl_init();
	curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://verify.twilio.com/v2/Services/Your_Service_Id/VerificationCheck',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'To=%2B'.$mobilenum.'&Code='.$otp,
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic QUNmNDNjZDI0OTYyZWFkMjE5MDFiMjU1ZDA1ZTIwMTVhMzphY2UwNGRhY2NkNDZmMzRlMDMyNjkwNjcyZjg3OWMxOA==',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));
$response1 = curl_exec($curl);
return $response1;
}

// send otp function
function sendOtp($mobilenum){
$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://verify.twilio.com/v2/Services/Your_Service_Id/Verifications',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => 'To=%2B'.$mobilenum.'&Channel=sms',
  CURLOPT_HTTPHEADER => array(
    'Authorization: Basic QUNmNDNjZDI0OTYyZWFkMjE5MDFiMjU1ZDA1ZTIwMTVhMzphY2UwNGRhY2NkNDZmMzRlMDMyNjkwNjcyZjg3OWMxOA==',
    'Content-Type: application/x-www-form-urlencoded'
  ),
));

$response = curl_exec($curl);
curl_close($curl);
$response = (array) json_decode($response);
return $response;
}
?>