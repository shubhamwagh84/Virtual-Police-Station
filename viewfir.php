<?php
include_once 'connect.php';
  $fir = $_GET['fir'];
     $query = "SELECT FirPath FROM fir where FirNo = '$fir'";
     $result = mysqli_query($conn_vps,$query);
     $row = mysqli_fetch_assoc($result);
    ?>
  <iframe id="pdfdesktop" src="<?php  echo $row['FirPath']; ?>" width="100%"style="height:100%;margin-top:20px;"></iframe>
    <?php
?>