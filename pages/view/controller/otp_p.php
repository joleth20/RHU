<?php
session_start();

$eml = $_SESSION["eml"];
$otp_code = $_POST["otp"];

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM user_details WHERE eml = '$eml'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);

if ($_SESSION["verified"] == "0") {
  if ($user_details["otp_code"] == $otp_code) {
     include 'pages/view/config/dbconfig.php';
     $query = "UPDATE user_details
            SET verified = '1'
            WHERE eml = '$eml'";
               //execute the query here
      $result = mysqli_query($conn, $query );

      // if ($result) {
      //   echo "sucess<br>";
      // }else{
      //   echo "failed<br>";
      // }
      $msg = "Account successfully verified!";
      unset($_SESSION["verified"]);
      $back = 1;
  }else{
    $msg = "Invalid Verification Code !";
    $back = 2;
  }
}else{
    if ($user_details["otp_code"] == $otp_code) {
        $msg = "Account successfully verified!";
        unset($_SESSION["verified"]);
        $_SESSION["newpass"] = "on";
        $back = 3;
      }else{
        $msg = "Invalid Verification Code !";
        $back = 2;
      }
}

if ($back == 1) {
    echo "<script>alert('$msg')</script>";
    echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
}
elseif ($back == 3) {
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=newpass';</script>";
}else{
    echo "<script>alert('$msg')</script>";
    echo "<script>window.history.back();</script>";
}



 ?>
