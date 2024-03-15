<?php
session_start();
$eml = $_SESSION["eml"];
$sched_value = $_POST["sched_value"];
$sched_id = $_POST["sched_id"];


include 'pages/view/config/dbconfig.php';
if ($sched_value == "Delete") {
    $sql = "SELECT * FROM schedule WHERE sched_id = '$sched_id'";
    $result = mysqli_query($conn, $sql);
    $sched_details = mysqli_fetch_assoc($result);
    $sched_details["time8am"] == "Booked" ? $denied = "1" : "";
    $sched_details["time9am"] == "Booked" ? $denied = "1" : "";
    $sched_details["time10am"] == "Booked" ? $denied = "1" : "";
    $sched_details["time11am"] == "Booked" ? $denied = "1" : "";
    $sched_details["time1pm"] == "Booked" ? $denied = "1" : "";
    $sched_details["time2pm"] == "Booked" ? $denied = "1" : "";
    $sched_details["time3pm"] == "Booked" ? $denied = "1" : "";
    $sched_details["time4pm"] == "Booked" ? $denied = "1" : "";
    $sched_details["time5pm"] == "Booked" ? $denied = "1" : "";
    $sched_details["time5pm"] == "Booked" ? $denied = "1" : "";

    if ($denied == "1") {
      echo "<script>alert('Some patients booked a slot on this date, this cannot be deleted')</script>";
      echo "<script>window.top.location.href='../RHU/?p=schedule';</script>";
    }else{
 
          $sql2 = "DELETE FROM schedule WHERE sched_id = '$sched_id'";
          $result2 = mysqli_query($conn, $sql2);
          if ($result) {
            $date_deleted = date("Y/m/d");
            $time_deleted = date("h:i a");
            $data_title = "Doctor Schedule Record";
            $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
                VALUES ('$data_title', '$sched_id', '$date_deleted', '$time_deleted', '$eml')";
             $result_delete = mysqli_query($conn, $query );
             if ($result_delete) {
               $msg =  'Record successfully deleted';
               $back = 1;
             }else{
               $msg =  'Failed to delete record, Please try again or contact website administrator';
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
    }
}elseif ($sched_value == "View" || $sched_value == "Edit") {
  echo '<form id="view" action="../RHU/?p=updatesched" method="post">';
  echo '<input type="hidden" name="sched_id" value="'.$sched_id.'">';
  echo '<input type="hidden" name="sched_value" value="'.$sched_value.'">';
  echo '<script>document.getElementById("view").submit();</script>';
}




 ?>
