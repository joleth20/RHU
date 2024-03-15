<?php
session_start();

$user_id = $_SESSION["user_id"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
$input_date = $_POST["input_date"];
if (isset($_POST['input_time'])){
  $input_time = implode(',', $_POST['input_time']);
}

$input_time_exp = explode(',', $input_time);
$time8am = "Not Available";
$time9am = "Not Available";
$time10am = "Not Available";
$time11am = "Not Available";
$time1pm = "Not Available";
$time2pm = "Not Available";
$time3pm = "Not Available";
$time4pm = "Not Available";
$time5pm = "Not Available";
foreach ($input_time_exp as $value) {
  if ($value == "08:00 AM") {
    $time8am = "Open";
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "09:00 AM") {
    $time9am = "Open";

  }
}
foreach ($input_time_exp as $value) {
  if ($value == "10:00 AM") {
    $time10am = "Open";

  }
}
foreach ($input_time_exp as $value) {
  if ($value == "11:00 AM") {
    $time11am = "Open";

  }
}
foreach ($input_time_exp as $value) {
  if ($value == "01:00 PM") {
    $time1pm = "Open";
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "02:00 PM") {
    $time2pm = "Open";
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "03:00 PM") {
    $time3pm = "Open";
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "04:00 PM") {
    $time4pm = "Open";
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "05:00 PM") {
    $time5pm = "Open";
  }
}

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM schedule WHERE input_date = '$input_date' and fullname = '$doctor_fullname'";
$result = mysqli_query($conn, $sql);
$schedule = mysqli_fetch_assoc($result);

if ($schedule["input_date"] == $input_date) {
   $msg = "Date selected already exist!";
   $back = 2;
}else {
  $query = "INSERT INTO schedule(user_id, fullname, input_date, input_time, time8am, time9am, time10am, time11am, time1pm, time2pm, time3pm, time4pm, time5pm)
      VALUES ('$user_id', '$doctor_fullname', '$input_date', '$input_time', '$time8am', '$time9am', '$time10am', '$time11am', '$time1pm', '$time2pm', '$time3pm', '$time4pm', '$time5pm')";
   $result = mysqli_query($conn, $query );
   if ($result) {
       $msg =  "New Schedule has been created successfully";
       $back = 1;
   }
   else {
       $msg =  "Failed to add new schedule, Please try again or contact website administrator";
       $back = 2;
   }
}


 if ($back == 1) {
 echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=schedule';</script>";
 }else{
 echo "<script>alert('$msg')</script>";
 echo "<script>window.history.back();</script>";
 }



 ?>
