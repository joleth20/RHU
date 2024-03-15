<?php


session_start();

$reports_title = $_POST["reports_title"];
$reports_link = $_POST["reports_link"];
$un = $_POST["un"];
$pw = $_POST["pw"];
$pw = hash('sha256',$pw);

include 'pages/view/config/dbconfig.php';
// Establishing the connection

$sql = "SELECT * FROM user_details WHERE eml = '$un'";
$result = mysqli_query($conn, $sql);
$user_details = mysqli_fetch_assoc($result);


$eml = $user_details["eml"];
$pass = $user_details["pw"];


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


  $_SESSION["password_req"] = "ON";
  $_SESSION['last_activity'] = time();
  $_SESSION['expire_time'] = 180;
  
  header("Refresh: 0.1; url=../RHU/?p=" . $reports_link);


}else{
  	echo "<script>alert('Incorrect Username/Password')</script>";
    echo "<script>window.history.back();</script>";
}


mysqli_close($conn);




?>