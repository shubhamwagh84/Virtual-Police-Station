<?php 

$servername = "localhost";
$usernamedb = "vps_admin";
$password = "vps_admin";
$dbname_aadhaar = "jobyardd_aadhaar";
$dbname_vps = "jobyardd_vps";
$dbname_police_station = "jobyardd_police_station";
$conn_aadhaar = mysqli_connect($servername, $usernamedb, $password, $dbname_aadhaar);
$conn_vps = mysqli_connect($servername, $usernamedb, $password, $dbname_vps);
$conn_police_station = mysqli_connect($servername, $usernamedb, $password, $dbname_police_station);


if (mysqli_connect_errno()){
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
}



?>