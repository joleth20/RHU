<?php
session_start();
$sms_id = $_POST["sms_id"];
$status = $_POST["sms_value"];
$eml = $_SESSION["eml"];

if ($status == "Edit") {
  echo '<form id="edit" action="../RHU/?p=updatetemplate" method="post">';
  echo '<input type="hidden" name="sms_id" value="'.$sms_id.'">';
  echo '<script>document.getElementById("edit").submit();</script>';
}elseif ($status == "Delete") {
  include 'pages/view/config/dbconfig.php';
  $sql = "DELETE FROM sms_template WHERE sms_id = '$sms_id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $date_deleted = date("Y/m/d");
    $time_deleted = date("h:i a");
    $data_title = "SMS Template Record";
    $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
        VALUES ('$data_title', '$sms_id', '$date_deleted', '$time_deleted', '$eml')";
     $result_delete = mysqli_query($conn, $query );
     if ($result_delete) {
       $msg =  'Record successfully deleted';
       $back = 2;
     }else{
       $msg =  'Failed to delete record, Please try again or contact website administrator';
       $back = 2;
     }
  }
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=smstemplate';</script>";
}
 ?>
