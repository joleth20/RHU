<?php

$notif_id = $_POST["notif_id"];
$notif_status = $_POST["notif_status"];
$notif_link = $_POST["notif_link"];

include 'pages/view/config/dbconfig.php';
$query = "UPDATE notification
       SET notif_status = '$notif_status'
       WHERE notif_id = '$notif_id'";
          //execute the query here
 $result = mysqli_query($conn, $query );
 if ($result) {
   echo "<script>window.top.location.href='../RHU/?p=$notif_link';</script>";
 }

 ?>
