<?php 
session_start();
$server = 'localhost';
$username = 'root';
$password = '';
$dbname = 'pdf';

$conn = mysqli_connect($server, $username, $password, $dbname);
	echo $_POST['ver'];
      if(isset($_POST['signdata']))
      {
      	//$data = mysqli_query($conn, "select data from pdggen where id=9");
      	print_r($_POST['ver']);

      }       


?>