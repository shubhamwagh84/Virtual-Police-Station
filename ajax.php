<?php

include 'connect.php';

include 'functions.php';

error_reporting(0);





if($_POST['loc'])
{
	$lat = $_POST['lat'];
	$lng = $_POST['lng'];

	$query=mysqli_query($conn_police_station,"SELECT *, ( 6371 * acos(cos(radians($lat)) * cos(radians(lat)) * cos(radians(longitude) - radians($lng)) + sin(radians($lat)) * sin(radians(lat ))) ) AS distance FROM police_details ORDER BY distance asc LIMIT 0,10");
$output = "";
	while ($rows = mysqli_fetch_array($query)) {

// $output .= '<tr>
// 								<td>'.$rows[1].'</td>
// 								<td>'.$rows[2].'</td>
// 								<td><button class="btn-block select" onclick="generate(this)" value="'.$rows[1].'" type="submit">Select</button ></td>
// 							</tr>

// ';

    $output .= '<option onclick="select_location(this)" id="'.$rows[2].'"  value="'.$rows[1].'">'.$rows[2].'</option>

';

	}
print_r($output);

}




if ($_POST['aadhaar_ver']=='true' || $_POST['phone_ver']=='true') {



  $input_data= $_POST['input_data'];

  if (is_registered($conn_vps,$input_data)==true){
  	@session_start();
  	$_SESSION['username'] = $input_data;
  	echo "registered";
  }


  //if user not registered
  else{


  	if ($_POST['aadhaar_ver']=='true') {

  	$query =mysqli_query($conn_aadhaar,"SELECT PhoneNo FROM aadhaar_info where AadharNo = '$input_data'");
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
   		   echo "success";
  		}
  		else{
  		   echo "Something Wrong Please Try Again Later";
  		}
    
  }
  else { // if person have aadhaar
    echo "Inavalid";
  }
}


 	else if($_POST['phone_ver']=='true') {
    $phone = $_POST['input_data'];
 		$random = mt_rand(1000,10000);
    send_msg($phone,$random);
 		$query = mysqli_query($conn_vps,"INSERT INTO bin (id,otp,create_at,phone) values (null,'$random',NOW(),'$input_data') ");
  	 		if ($query==true) {
  	 			echo "success";
  	 		}
 	}



  }


  }
 





?>