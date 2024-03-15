<?php
session_start();
$eml = $_SESSION["eml"];
date_default_timezone_set('Asia/Manila');
$status = $_POST["user_approval"];
$user_approval_id = $_POST["user_approval_id"];
$date_registered = $_POST["date_registered"];
$time_registered = $_POST["time_registered"];
$eml_reset = $_POST["eml"];

if ($status == "") {
  $msg = "Failed, Please try again";
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
}elseif ($status == "Delete") {
  include 'pages/view/config/dbconfig.php';
  $sql = "DELETE FROM user_details WHERE user_id = '$user_approval_id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $date_deleted = date("Y/m/d");
    $time_deleted = date("h:i a");
    $data_title = "User Account Record";
    $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
        VALUES ('$data_title', '$user_approval_id', '$date_deleted', '$time_deleted', '$eml')";
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
echo "<script>window.top.location.href='../RHU/?p=account_mgmt';</script>";

}elseif ($status == "Edit") {
  echo '<form id="edit" action="../RHU/?p=update_account" method="post">';
  echo '<input type="hidden" name="user_id" value="'.$user_approval_id.'">';
  echo '<script>document.getElementById("edit").submit();</script>';
}elseif ($status == "Reset") {
  echo $status;
  echo $eml_reset;
  echo '<form id="reset" action="../RHU/?p=update_password" method="post">';
  echo '<input type="hidden" name="user_id" value="'.$user_approval_id.'">';
  echo '<input type="hidden" name="eml" value="'.$eml_reset.'">';
  echo '<script>document.getElementById("reset").submit();</script>';

}
 ?>
