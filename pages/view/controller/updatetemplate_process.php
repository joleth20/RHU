<?php
$sms_id = $_POST["sms_id"];
$sms_title = $_POST["sms_title"];
$sms_content = $_POST["sms_content"];

include 'pages/view/config/dbconfig.php';
$sql = "UPDATE sms_template
       SET sms_title = '$sms_title',
          sms_content = '$sms_content'
       WHERE sms_id = '$sms_id'";

$result = mysqli_query($conn, $sql);
if ($result) {
  $msg = "Record Updated";
  $back = 1;
}else{
  echo mysqli_error($conn);
  $msg = "Failed to Update Record";
  $back = 2;
}
if ($back == 1) {
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=smstemplate';</script>";
}else{
  echo "<script>alert('$msg')</script>";
  echo "<script>window.history.back();</script>";
}
 ?>
