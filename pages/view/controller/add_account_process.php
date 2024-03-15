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
$user_type = $_POST["user_type"];
$otp_code = random_int(100000, 999999);
$verified = "0";
$date_registered = date('Y-m-d');
$time_registered = date("h:i a");

if(!empty($_POST["pw"]) && $_POST["pw"] != "" ){

    if (strlen($_POST["pw"]) <= '7') {
        $msg = "Your Password Must Contain At Least 8 characters!";
        $back = 2;
    }
    elseif(!preg_match("#[0-9]+#",$_POST["pw"])) {
        $msg = "Your Password Must Contain At Least 1 Number !";
        $back = 2;
    }
    elseif(!preg_match("#[A-Z]+#",$_POST["pw"])) {
        $msg = "Your Password Must Contain At Least 1 Capital Letter !";
        $back = 2;
    }
    elseif(!preg_match("#[a-z]+#",$_POST["pw"])) {
        $msg = "Your Password Must Contain At Least 1 Lowercase Letter !";
        $back = 2;
    }
    elseif(!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $_POST["pw"])) {
        $msg = "Your Password Must Contain At Least 1 Special Character !";
        $back = 2;
    }
    elseif($pw != $cpw){
        $msg = "Password and Confirm Password not matched !";
    }
    else{
      include 'pages/view/config/dbconfig.php';
      $sql = "SELECT * FROM user_details WHERE eml = '$eml'";
      $result = mysqli_query($conn, $sql);
      $user_details = mysqli_fetch_assoc($result);

      if ($user_details["eml"] == $eml) {
         $msg = "Email already exist";
         $back = 2;
      }else{
         $pw = hash('sha256',$pw);
         include 'pages/view/config/dbconfig.php';
         $query = "INSERT INTO user_details(fname, mi, lname, bday, age, gender, address_stblc, address_brgy, address_city, contact_no, phealth, eml, pw, user_type, otp_code, verified, date_registered, time_registered)
             VALUES ('$fname', '$mi', '$lname', '$bday', '$age', '$gender', '$address_stblc', '$address_brgy', '$address_city','$contact_no', '$phealth', '$eml', '$pw','$user_type', '$otp_code', '$verified', '$date_registered', '$time_registered')";
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
              $msg =  "Failed to create account, Please try again or contact website administrator";
              $back = 2;
          }

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
  }else{
      echo "<script>alert('$msg')</script>";
      echo "<script>window.history.back();</script>";
  }
}

 ?>
