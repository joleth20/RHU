<?php
session_start();
$sms_title = $_POST["sms_title"];
$sms_content = $_POST["sms_content"];
$doctor = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
$user_id = $_SESSION["user_id"];
$date_created = date('Y-m-d');
$time_created = date("h:i a");

include 'pages/view/config/dbconfig.php';
$query = "INSERT INTO sms_template(sms_title, sms_content, user_id, doctor, date_created, time_created)
    VALUES ('$sms_title', '$sms_content','$user_id', '$doctor', '$date_created', '$time_created')";
 $result = mysqli_query($conn, $query );
 if ($result) {
   $msg =  "New SMS Template has been added";
   $back = 1;
 }else{
   $msg =  "Failed to add template";
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
