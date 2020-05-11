<?php

include 'connect.php';
error_reporting(0);
function is_registered($conn,$input_data) {

	$query = "SELECT id FROM users where AadhaarNo = '$input_data' || PhoneNo = '$input_data'";
	$result = mysqli_query($conn,$query);
    if (mysqli_num_rows($result)==1) {
    	return true;
    }

    return false;
}


function send_msg($phone,$message)
{
	$username = "intakhabsheikh786@gmail.com";
	$hash = "088e624b4c0b032952b9c2a5dcad1a67c5f90186812b4c5aac1e53c021443378";
	$test = "0";
	$sender = "TXTLCL"; 
	$message = urlencode($message);
	$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$phone."&test=".$test;
  	$ch = curl_init('http://api.textlocal.in/send/?');
  	curl_setopt($ch, CURLOPT_POST, true);
  	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  	$result = curl_exec($ch);
  	curl_close($ch);

  	if ($result==true) {
  		return true;
  	}

  	return false;
}



function registration($conn,$details)
{
	
	$name = $details['name'] ;
	$aadhaar = $details['aadhaar'];
	$dob = $details['d_o_b'];
	$address = $details['address'];
	$gender = $details['gender'];
	$phone = $details['phone'];
	$userid = substr($details['2'], 0,5).rand(1000,9999);
	$query = "INSERT INTO users values (null,'$name','$aadhaar','$dob','$address','$gender',null,'$phone','$userid')";
	$result = mysqli_query($conn,$query);
	
	if(!$result){
		return false;
	}
	echo json_encode($result);
	return true;
	
}





if($_POST['data']['isReg']=='No')
{
	//print_r($_POST['data']);
	$details = $_POST['data'];
	registration($conn_vps,$details);
}



?>