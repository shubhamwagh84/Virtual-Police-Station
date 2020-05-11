<?php 
include 'connect.php';
error_reporting(0);
if ($_POST['data']['otp_ver']) {

	if ($_POST['data']['isReg']=='Yes') {

		$otp = $_POST['data']['otp'];
		$input_data = $_POST['data']['input_data'];
		$query = "SELECT * FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_vps,$query);
		$count = mysqli_num_rows($row);
		if ($count==1) {
		$query = "SELECT * FROM users where AadhaarNo = '$input_data' || PhoneNo = '$input_data'";
		$rows = mysqli_query($conn_vps,$query);
		$details = mysqli_fetch_row($rows);
		array_push($details, 'ver_success');
		$json = json_encode($details);
		$query = "DELETE FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_vps,$query);
		echo $json;
		}
		else{
			echo json_encode('ver_failed');
		}
	}

	 else {


		if ($_POST['data']['ver_type']=="aadhaar") {
		$otp = $_POST['data']['otp'];
		$aadhaar = $_POST['data']['input_data'];
		$query = "SELECT * FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_aadhaar,$query);
		$count = mysqli_num_rows($row);
		if ($count==1) {
		$query = "SELECT * FROM aadhaar_info where AadhaarNo = '$aadhaar'";
		$rows = mysqli_query($conn_aadhaar,$query);
		$details = mysqli_fetch_row($rows);
		array_push($details, 'ver_success');
		$json = json_encode($details);
		echo $json;
		$query = "DELETE FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_aadhaar,$query);
	} else {
		echo json_encode("ver_failed");
	}

		
		
	} else if($_POST['data']['ver_type']=="phone") {

		$otp = $_POST['data']['otp'];
		$phone = $_POST['data']['input_data'];
		$query = "SELECT * FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_vps,$query);
		$count = mysqli_num_rows($row);
		if ($count==1) {
		echo json_encode("ver_success");
		$query = "DELETE FROM bin where otp = '$otp'";
		$row = mysqli_query($conn_vps,$query);
		}
		else
		{
			echo json_encode("ver_failed");
		}
		
	}

	
	}
	

	
	
	

	
} 


?>