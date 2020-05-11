<?php
include 'connect.php';
include 'functions.php';
if($_POST['data']['list_complaint']){
$input_data = $_POST['data']['input_data'];
$query = " SELECT * FROM fir where UserId = (SELECT UserId FROM users where AadhaarNO = '$input_data' OR PhoneNo = '$input_data')";
$result = mysqli_query($conn_vps,$query);
$output = '';
while ($rows = mysqli_fetch_assoc($result)) {
$output .= '<tr>
    <td>'.$rows['FirNo'].'</td>
    <td>
        <button class="btn btn-danger btn-block" value="'.$rows['FirNo'].'" name="'.$rows['PsCode'].'" onclick="query_page(this)" type="submit">Query</button >
    </td>
    <td>
    <a href="viewfir.php?fir='.$rows['FirNo'].'" class="btn btn-danger btn-block"  type="submit" >View</a >
</td>
    <td>
        <label style="font-size:15px" value="'.$rows['FirNo'].'" name="'.$rows['PsCode'].'"  type="submit">'.$rows['status'].'</label >
    </td>
    
    
    
</tr>
';
}
print_r($output);
}


if($_POST['data']['query_submit']){

    $input_data = $_POST['data']['input_data'];
    $msg = $_POST['data']['query'];
    $PsCode = $_POST['data']['PsCode'];
    $FirNo = $_POST['data']['FirNo'];

    $query = "SELECT UserId,PhoneNo FROM users where AadhaarNO = '$input_data' OR PhoneNo = '$input_data'";
    $UserId = mysqli_fetch_assoc(mysqli_query($conn_vps,$query))['UserId'];
    $PhoneNo = mysqli_fetch_assoc(mysqli_query($conn_vps,$query))['PhoneNo'];
   

    $query = " SELECT * FROM cctns_sent_query where UserId = '$UserId' AND FirNo = '$FirNo'";

    $count = mysqli_num_rows(mysqli_query($conn_vps,$query));
     if ($count==0) {
    
         $QueryId = rand(100,10000);
         $msgtophone = "Your Query Successfully submitted. Your QueryId is :".$QueryId;
         send_msg($PhoneNo,$msgtophone);
         $result = mysqli_query($conn_vps,"INSERT INTO cctns_sent_query values (null,'$QueryId','$UserId','$FirNo','$msg',now(),'$PsCode')");
         if ($result) {
            echo json_encode("query_submitted");
         }
         
     }
     else
     {
        echo json_encode("query_failed");
     }


}


?>