<?php
session_start();
$sched_id = $_POST["sched_id"];
$user_id = $_SESSION["user_id"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
$input_date = $_POST["input_date"];
if (isset($_POST['input_time'])){
  $input_time = implode(',', $_POST['input_time']);
}

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM schedule WHERE sched_id = '$sched_id'";
$result = mysqli_query($conn, $sql);
$sched_details = mysqli_fetch_assoc($result);


$time8am ="Not Available";
$time9am = "Not Available";
$time10am = "Not Available";
$time11am = "Not Available";
$time1pm = "Not Available";
$time2pm = "Not Available";
$time3pm = "Not Available";
$time4pm = "Not Available";
$time5pm = "Not Available";
$input_time_exp = explode(',', $input_time);
foreach ($input_time_exp as $value) {
  if ($value == "08:00 AM") {
    if ($sched_details["time8am"] == "Not Available") {
      $time8am = "Open";
      break;
    }elseif ($sched_details["time8am"] == "Booked") {
      $time8am = "Booked";
      break;
    }elseif ($sched_details["time8am"] == "Open") {
      $time8am = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "09:00 AM") {
    if ($sched_details["time9am"] == "Not Available") {
      $time9am = "Open";
      break;
    }elseif ($sched_details["time9am"] == "Booked") {
      $time9am = "Booked";
      break;
    }elseif ($sched_details["time9am"] == "Open") {
      $time9am = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "10:00 AM") {
    if ($sched_details["time10am"] == "Not Available") {
      $time10am = "Open";
      break;
    }elseif ($sched_details["time10am"] == "Booked") {
      $time10am = "Booked";
      break;
    }elseif ($sched_details["time10am"] == "Open") {
      $time10am = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "11:00 AM") {
    if ($sched_details["time11am"] == "Not Available") {
      $time11am = "Open";
      break;
    }elseif ($sched_details["time11am"] == "Booked") {
      $time11am = "Booked";
      break;
    }elseif ($sched_details["time11am"] == "Open") {
      $time11am = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "01:00 PM") {
    if ($sched_details["time1pm"] == "Not Available") {
      $time1pm = "Open";
      break;
    }elseif ($sched_details["time1pm"] == "Booked") {
      $time1pm = "Booked";
      break;
    }elseif ($sched_details["time1pm"] == "Open") {
      $time1pm = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "02:00 PM") {
    if ($sched_details["time2pm"] == "Not Available") {
      $time2pm = "Open";
      break;
    }elseif ($sched_details["time2pm"] == "Booked") {
      $time2pm = "Booked";
      break;
    }elseif ($sched_details["time2pm"] == "Open") {
      $time2pm = "Open";
      break;
    }
  }
}

foreach ($input_time_exp as $value) {
  if ($value == "03:00 PM") {
    if ($sched_details["time3pm"] == "Not Available") {
      $time3pm = "Open";
      break;
    }elseif ($sched_details["time3pm"] == "Booked") {
      $time3pm = "Booked";
      break;
    }elseif ($sched_details["time3pm"] == "Open") {
      $time3pm = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "04:00 PM") {
    if ($sched_details["time4pm"] == "Not Available") {
      $time4pm = "Open";
      break;
    }elseif ($sched_details["time4pm"] == "Booked") {
      $time4pm = "Booked";
      break;
    }elseif ($sched_details["time4pm"] == "Open") {
      $time4pm = "Open";
      break;
    }
  }
}
foreach ($input_time_exp as $value) {
  if ($value == "05:00 PM") {
    if ($sched_details["time5pm"] == "Not Available") {
      $time5pm = "Open";
      break;
    }elseif ($sched_details["time5pm"] == "Booked") {
      $time5pm = "Booked";
      break;
    }elseif ($sched_details["time5pm"] == "Open") {
      $time5pm = "Open";
      break;
    }
  }
}

$query = "UPDATE schedule
       SET input_date = '$input_date',
       input_time = '$input_time',
       time8am = '$time8am',
       time9am = '$time9am',
       time10am = '$time10am',
       time11am = '$time11am',
       time1pm = '$time1pm',
       time2pm = '$time2pm',
       time3pm = '$time3pm',
       time4pm = '$time4pm',
       time5pm = '$time5pm'
       WHERE sched_id = '$sched_id'";
$result = mysqli_query($conn, $query);

   if ($result) {
       $msg =  "Record Updated";
       $back = 1;
   }
   else {
       $msg =  "Failed to update record, Please try again or contact website administrator";
       $back = 2;
   }



 if ($back == 1) {
 echo "<script>alert('$msg')</script>";
 echo "<script>window.top.location.href='../RHU/?p=schedule';</script>";
 }else{
 echo "<script>alert('$msg')</script>";
 echo "<script>window.history.back();</script>";
 }



 ?>
