<?php
session_start();
$eml = $_SESSION["eml"];
$contact_no = $_SESSION["contact_no"];
$patient_name = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
$otp_code = random_int(100000, 999999);

include 'pages/view/config/dbconfig.php';
$query = "UPDATE user_details
       SET otp_code = '$otp_code'
       WHERE eml = '$eml'";
          //execute the query here
 $result = mysqli_query($conn, $query );
 if ($result) {
     $msg =  "New OTP Verification Code has been sent to your Mobile Number";
     $back = 1;
 }
 else {
     $msg =  "Failed to generate new OTP Code, Please try again or contact website administrator";
     $back = 2;
 }
 if ($back == 1) {
     echo "<script>alert('$msg')</script>";
     echo '<form id="otp_register" action="../RHU/?p=notify" method="post">';
     echo '<input type="hidden" name="number" value="'.$contact_no.'">';
     echo '<input type="hidden" name="message_type" value="otp_register">';
     echo '<input type="hidden" name="otp_code" value="'.$otp_code.'">';
     echo '<input type="hidden" name="patient_name" value="'.$patient_name.'">';
     echo '<script>document.getElementById("otp_register").submit();</script>';
 }else{
     echo "<script>alert('$msg')</script>";
     echo "<script>window.history.back();</script>";
 }

?>
