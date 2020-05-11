<?php 
include 'connect.php';

include 'functions.php';

if ($_POST['data']['ver_type']=='aadhaar' || $_POST['data']['ver_type']=='phone') {



  $input_data= $_POST['data']['input_data'];

  if (is_registered($conn_vps,$input_data)==true){

          $query = "SELECT PhoneNo FROM users where AadhaarNo = '$input_data' OR  PhoneNo = '$input_data'";
          $result = mysqli_query($conn_vps,$query);
          $rows = mysqli_fetch_array($result);
          $phone = $rows['PhoneNo'];
          $random = mt_rand(1000,10000);
          send_msg($phone,$random);
          $query = mysqli_query($conn_vps,"INSERT INTO bin (id,otp,create_at,phone) values (null,'$random',NOW(),'$phone') ");
  	   $_SESSION['username'] = $input_data;
  	   echo json_encode("registered");
  }


  //if user not registered
  else{


  	if ($_POST['data']['ver_type']=='aadhaar') {

  	$query =mysqli_query($conn_aadhaar,"SELECT PhoneNo FROM aadhaar_info where AadhaarNo = '$input_data'");
  	$rows = mysqli_fetch_array($query);
  	$count = mysqli_num_rows($query);
  	$phone = $rows[0];	
	if ($count==1) { // if person have aadhaar

		$random = mt_rand(1000,10000);
		$msg1="Your OTP Is ";
		$msg2="  Valid For 5 Minute.";
		$message = $msg1.$random.$msg2;
		$result = send_msg($phone,$message);

		if($result==true) {
   		   $query = mysqli_query($conn_aadhaar,"INSERT INTO bin (id,otp,create_at,aadhaar) values (null,'$random',NOW(),'$input_data') ");
   		   echo json_encode("not_registered");
  		}
  		else{
  		   echo json_encode("Something Wrong Please Try Again Later");
  		}
  }
  else { // if person have not aadhaar
    echo json_encode("Inavalid");
  }
}


 	else if($_POST['data']['ver_type']=='phone') {
    $phone = $_POST['data']['input_data'];
 		$random = mt_rand(1000,10000);
    send_msg($phone,$random);
 		$query = mysqli_query($conn_vps,"INSERT INTO bin (id,otp,create_at,phone) values (null,'$random',NOW(),'$input_data') ");
  	 		if ($query==true) {
  	 			echo json_encode("not_registered");
  	 		}
 	}



  }


  }

?>