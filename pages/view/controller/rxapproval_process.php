<?php
session_start();
$eml = $_SESSION["eml"];
date_default_timezone_set('Asia/Manila');
$status = $_POST["rx_approval"];
$rx_approval_id = $_POST["rx_approval_id"];
$act_date = date("Y/m/d");
$act_time = date("h:i a");
$user_id = $_POST["user_id"];


if ($status == "") {
  $msg = "Failed, Please try again";
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
}elseif ($status == "Delete") {
  include 'pages/view/config/dbconfig.php';
  $sql = "DELETE FROM medication_refills WHERE rx_id = '$rx_approval_id'";
  $result = mysqli_query($conn, $sql);
  if ($result) {
    $date_deleted = date("Y/m/d");
    $time_deleted = date("h:i a");
    $data_title = "Patient Medication Refill Record";
    $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
        VALUES ('$data_title', '$rx_approval_id', '$date_deleted', '$time_deleted', '$eml')";
     $result_delete = mysqli_query($conn, $query );
     if ($result_delete) {
       $msg =  'Record successfully deleted';
       $back = 3;
     }else{
       $msg =  'Failed to delete record, Please try again or contact website administrator';
       $back = 2;
     }
  }
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
}elseif($status == "Edit"){
  echo '<form id="view" action="../RHU/?p=updaterx" method="post">';
  echo '<input type="hidden" name="rx_id" value="'.$rx_approval_id.'">';
  echo '<input type=submit>';
  echo '<script>document.getElementById("view").submit();</script>';
    
}elseif ($status == "View") {
  echo '<form id="view" action="../RHU/?p=updaterx" method="post">';
  echo '<input type="hidden" name="rx_id" value="'.$rx_approval_id.'">';
  echo '<input type=submit>';
  echo '<script>document.getElementById("view").submit();</script>';
}else{
    include 'pages/view/config/dbconfig.php';
    $query = "UPDATE medication_refills
           SET status = '$status',
           act_date = '$act_date',
           act_time = '$act_time'
           WHERE rx_id = '$rx_approval_id'";
              //execute the query here
     $result = mysqli_query($conn, $query );
     if ($result) {
       $sql2 = "SELECT * FROM medication_refills WHERE rx_id = '$rx_approval_id'";
       $result2 = mysqli_query($conn, $sql2 );
       $rx_details = mysqli_fetch_assoc($result2);
       $req_date = $rx_details["req_date"];
       $req_time = $rx_details["req_time"];
       $doctor = $rx_details["doctor"];

       $sql3 = "SELECT * FROM user_details WHERE user_id = '$user_id'";
       $result3 = mysqli_query($conn, $sql3 );
       $user_details = mysqli_fetch_assoc($result3);
       $patient_name = $user_details["user_id"];
       $contact_no = $user_details["contact_no"];
       
       $query = "INSERT INTO notification(notif_type, id, status, fullname,  notif_status, notif_link, user_type)
           VALUES ('Medication Refills', '$rx_approval_id', '$status', '$patient_name', '1', 'rx', '4')";
        $result = mysqli_query($conn, $query );
        if($result){
            $sql2 = "SELECT * FROM user_details WHERE user_id = '$doctor'";
            $result2 = mysqli_query($conn, $sql2 );
            $doctor_details = mysqli_fetch_assoc($result2);
            $doctor_fullname = $doctor_details["fname"].' '.$doctor_details["mi"].' '.$doctor_details["lname"];
            
            $sql3 = "SELECT * FROM user_details WHERE user_id = '$patient_name'";
            $result3 = mysqli_query($conn, $sql3 );
            $patient_details = mysqli_fetch_assoc($result3);
            $patient_fullname = $patient_details["fname"].' '.$patient_details["mi"].' '.$patient_details["lname"];
        }


       $msg =  'Medication Request has been '.$status;
       $back = 1;
     }
     else {
         $msg =  "Failed to update record, Please try again or contact website administrator";
         $back = 2;
     }
    if ($back == 1) {
    echo "<script>alert('$msg')</script>";
    echo '<form id="notif" action="../RHU/?p=notify" method="post">';
    echo '<input type="hidden" name="number" value="'.$contact_no.'">';
    echo '<input type="hidden" name="message_type" value="rx">';
    echo '<input type="hidden" name="status" value="'.$status.'">';
    echo '<input type="hidden" name="req_date" value="'.$req_date.'">';
    echo '<input type="hidden" name="req_time" value="'.$req_time.'">';
    echo '<input type="hidden" name="doctor" value="'.$doctor_fullname.'">';
    echo '<input type="hidden" name="patient_name" value="'.$patient_fullname.'">';
    echo '<script>document.getElementById("notif").submit();</script>';
  }elseif ($back == "3") {
    echo "<script>alert('$msg')</script>";
    echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
  }else{
    echo "<script>alert('$msg')</script>";
    echo "<script>window.history.back();</script>";
    }
}
 ?>
