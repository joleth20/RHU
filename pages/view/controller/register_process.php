<?php
session_start();

$fname = $_POST["fname"];
$mi = $_POST["mi"];
$lname = $_POST["lname"];
$bday = $_POST["bday"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$address_stblc = $_POST["address_stblc"];
$address_brgy = $_POST["address_brgy"];
$address_city = $_POST["address_city"];
$contact_no = $_POST["contact_no"];
$phealth = $_POST["phealth"];
$eml = $_POST["eml"];
$pw = $_POST["pw"];
$cpw = $_POST["cpw"];
$otp_code = random_int(100000, 999999);
$verified = "0";
$date_registered = date('Y-m-d');
$time_registered = date("h:i a");
$register_type = $_POST["register_type"];


if($register_type == "admin_register"){
    $services = $_POST["services"];
    $user_type = $_POST["user_type"];
    include 'pages/view/config/dbconfig.php';
    $pw = hash('sha256',$pw);
     include 'pages/view/config/dbconfig.php';
     $query = "INSERT INTO user_details(fname, mi, lname, bday, age, gender, address_stblc, address_brgy, address_city, contact_no, phealth, eml, pw, user_type, otp_code, verified, date_registered, time_registered, services, profile_pic)
         VALUES ('$fname', '$mi', '$lname', '$bday', '$age', '$gender', '$address_stblc', '$address_brgy', '$address_city','$contact_no', '$phealth', '$eml', '$pw','$user_type', '$otp_code', '$verified', '$date_registered', '$time_registered', '$services','default.png')";
      $result = mysqli_query($conn, $query );
      if ($result) {
          $msg =  "Account has been created successfully";
          $back = 3;
      }
      else {
          echo mysqli_error($conn);
          $msg =  "Failed to create account, Please try again or contact website administrator";
          $back = 2;
     }
}else{
    $user_type = "4";
    include 'pages/view/config/dbconfig.php';
    $pw = hash('sha256',$pw);
     include 'pages/view/config/dbconfig.php';
     $query = "INSERT INTO user_details(fname, mi, lname, bday, age, gender, address_stblc, address_brgy, address_city, contact_no, phealth, eml, pw, user_type, otp_code, verified, date_registered, time_registered, profile_pic)
         VALUES ('$fname', '$mi', '$lname', '$bday', '$age', '$gender', '$address_stblc', '$address_brgy', '$address_city','$contact_no', '$phealth', '$eml', '$pw','$user_type', '$otp_code', '$verified', '$date_registered', '$time_registered', 'default.png')";
      $result = mysqli_query($conn, $query );
      if ($result) {
          $msg =  "Account has been created successfully";
          $back = 1;
          $_SESSION["eml"] = $eml;
          $_SESSION["contact_no"] = $contact_no;
          $_SESSION["fname"] = $fname;
          $_SESSION["mi"] = $mi;
          $_SESSION["lname"] = $lname;
          $_SESSION["verified"] = "0";
      }
      else {
          echo mysqli_error($conn);
          $msg =  "Failed to create account, Please try again or contact website administrator";
          $back = 2;
     }
      
}    
   

  if ($back == 1) {
      echo "<script>alert('$msg')</script>";
      echo '<form id="otp_register" action="../RHU/?p=notify" method="post">';
      echo '<input type="hidden" name="number" value="'.$contact_no.'">';
      echo '<input type="hidden" name="message_type" value="otp_register">';
      echo '<input type="hidden" name="otp_code" value="'.$otp_code.'">';
      echo '<input type="hidden" name="patient_name" value="'.$fname." ".$mi." ".$lname.'">';
      echo '<script>document.getElementById("otp_register").submit();</script>';
  }elseif($back == 3){
      echo "<script>alert('$msg')</script>";
      echo '<form id="otp_register_admin" action="../RHU/?p=notify" method="post">';
      echo '<input type="hidden" name="number" value="'.$contact_no.'">';
      echo '<input type="hidden" name="message_type" value="otp_register_admin">';
      echo '<input type="hidden" name="otp_code" value="'.$otp_code.'">';
      echo '<input type="hidden" name="patient_name" value="'.$fname." ".$mi." ".$lname.'">';
      echo '<script>document.getElementById("otp_register_admin").submit();</script>';
    }else{
      echo "<script>alert('$msg')</script>";
      echo "<script>window.history.back();</script>";
  }


 ?>
