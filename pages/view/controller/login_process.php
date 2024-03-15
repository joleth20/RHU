<?php
session_start();

$un = $_POST["un"];
$pw = $_POST["pw"];
$pw = hash('sha256',$pw);

include 'pages/view/config/dbconfig.php';
// Establishing the connection

$sql = "SELECT * FROM user_details WHERE eml = '$un'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);

$user_id = $user_details["user_id"];
$fname = $user_details["fname"];
$mi = $user_details["mi"];
$lname = $user_details["lname"];
$bday = $user_details["bday"];
$age = $user_details["age"];
$gender = $user_details["gender"];
$address_stblc = $user_details["address_stblc"];
$address_brgy = $user_details["address_brgy"];
$address_city =  $user_details["address_city"];
$contact_no =  $user_details["contact_no"];
$phealth =  $user_details["phealth"];
$eml = $user_details["eml"];
$pass = $user_details["pw"];
$services = $user_details["services"];
$user_type = $user_details["user_type"];
$verified = $user_details["verified"];
$profile_pic = $user_details["profile_pic"];

$unpw = 0;
if($eml == "" || $pass == ""){
	$unpw == 0;
}else{
	if($eml == $un){
		if($pass == $pw){
			$unpw = 1;
		}
	}
}

if ($unpw == 1) {


  $_SESSION["dashboard"] = "on";
  // $_SESSION['expire_time'] = 1800; //auto logout after 3 minutes of inactivity
  $_SESSION["user_id"] = $user_id;
  $_SESSION["fname"] = $fname;
  $_SESSION["mi"] = $mi;
  $_SESSION["lname"] = $lname;
  $_SESSION["bday"] = $bday;
  $_SESSION["age"] = $age;
  $_SESSION["gender"] = $gender;
  $_SESSION["address_stblc"] = $address_stblc;
  $_SESSION["address_brgy"] = $address_brgy;
  $_SESSION["address_city"] = $address_city;
  $_SESSION["contact_no"] = $contact_no;
  $_SESSION["phealth"] = $phealth;
  $_SESSION["eml"] = $eml;
  $_SESSION["services"] = $services;
  $_SESSION["user_type"] = $user_type;
  $_SESSION["verified"] = $verified;
  $_SESSION["profile_pic"] = $profile_pic;

  if ($verified == "0") {
    header("Refresh: 0.01; url=../RHU/?p=otp");
  }else{
		if ($user_type == 1) {
			header("Refresh: 0.01; url=../RHU/?p=dashboard_a");
		}else{
			header("Refresh: 0.01; url=../RHU/?p=dashboard");
		}

  }
}else{
  	echo "<script>alert('Incorrect Username/Password')</script>";
    session_destroy();
    header("Refresh: 0.01; url=../RHU");
}


mysqli_close($conn);



 ?>
