<?php 

$servername = "localhost";
$usernamedb = "root";
$password = "";
$dbname = "gps_location"; //provide same name as database


$conn = mysqli_connect($servername, $usernamedb, $password, $dbname);
if (mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}






$latitude = $_GET['latitude'];
$longitude = $_GET['longitude'];



$query  = "INSERT INTO gps_location VALUES (null,'$latitude','$longitude')";

$result = mysqli_query($conn,$query);


if (!$result) {
	echo mysqli_errno($conn);
}
else{
	echo "SuccessFull Inserted";
}






?>