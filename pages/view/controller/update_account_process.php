<?php
session_start();
$user_id_curr = $_SESSION["user_id"];
$user_type_curr = $_SESSION["user_type"];

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
$user_type = $_POST["user_type"];
$user_id = $_POST["user_id"];
if(isset($_POST["update_type"])){
    $update_type = $_POST["update_type"];
}else{
    $update_type = "";
}

if(isset($_POST["services"])){
    $services = $_POST["services"];
}else{
    $services = "";
}

include 'pages/view/config/dbconfig.php';
$sql = "UPDATE user_details
       SET fname = '$fname',
          mi = '$mi',
          lname = '$lname',
          bday = '$bday',
          age = '$age',
          gender = '$gender',
          address_stblc = '$address_stblc',
          address_brgy = '$address_brgy',
          address_city = '$address_city',
          contact_no = '$contact_no',
          phealth = '$phealth',
          eml = '$eml',
          user_type = '$user_type',
          services = '$services'
       WHERE user_id = '$user_id'";

$result = mysqli_query($conn, $sql);
if ($result) {
  if($user_type_curr == "2" || $user_type_curr == "3" || $user_type_curr == "4"){
      $_SESSION["fname"] = $fname;
  }else{

      if($user_id_curr == $user_id){
          $_SESSION["fname"] = $fname;
      }
  }
  
  
  $msg = "Record Updated";
  $back = 1;
}else{
  echo mysqli_error($conn);
  $msg = "Failed to Update Record";
  $back = 2;
}
if ($back == 1) {
echo "<script>alert('$msg')</script>";
if($user_id_curr == $user_id){
   if($user_type_curr == "1"){
        echo "<script>window.top.location.href='../RHU/?p=dashboard_a';</script>";
    }else{
        echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
    }
}else{
    echo "<script>window.top.location.href='../RHU/?p=account_mgmt';</script>";
  }
}else{
echo "<script>alert('$msg')</script>";
echo "<script>window.history.back();</script>";
}


 ?>
