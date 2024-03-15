<?php
session_start();

$eml = $_SESSION["eml"];
$pw = $_POST["pw"];
$cpw = $_POST["cpw"];
$user_type_reset = $_POST["user_type_reset"];
$user_id = $_POST["user_id"];


      $pw = hash('sha256',$pw);
      include 'pages/view/config/dbconfig.php';
      if($user_type_reset == 1){
          $query = "UPDATE user_details
                 SET pw = '$pw'
                 WHERE user_id = '$user_id'";
      }else{
          $query = "UPDATE user_details
                 SET pw = '$pw'
                 WHERE eml = '$eml'";
      }
       $result = mysqli_query($conn, $query );
       if ($result) {
           $msg =  "Password Updated";
           $back = 1;
           if($user_type_reset != "1"){
           session_destroy();
           }
       }
       else {
           $msg =  "Failed to update password, Please try again or contact website administrator";
           $back = 2;
       }



if ($back == 1) {
    echo "<script>alert('$msg')</script>";
    echo "<script>window.top.location.href='../RHU/?p=login';</script>";
}else{
    echo "<script>alert('$msg')</script>";
    echo "<script>window.history.back();</script>";
}


 ?>
