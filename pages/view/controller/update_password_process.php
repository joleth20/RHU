<?php
session_start();

$user_ = $_POST["user_id"];
$pw = $_POST["pw"];
$cpw = $_POST["cpw"];
$admin_reset = $_POST["admin_reset"];


      $pw = hash('sha256',$pw);
      include 'pages/view/config/dbconfig.php';
      $query = "UPDATE user_details
             SET pw = '$pw'
             WHERE user_id = '$user_id'";
                //execute the query here
       $result = mysqli_query($conn, $query );
       if ($result) {
           $msg =  "Password Updated";
           $back = 1;
            session_destroy();
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
