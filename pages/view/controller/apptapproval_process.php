<?php
session_start();
$eml = $_SESSION["eml"];
date_default_timezone_set('Asia/Manila');
$status = $_POST["appt_approval"];
$appt_approval_id = $_POST["appt_approval_id"];
$act_date = date("Y-m-d");
$act_time = date("h:i a");
$req_time = $_POST["req_time"];
$req_date = $_POST["req_date"];
$doctor = $_POST["doctor"];


if ($status == "") {
  $msg = "Failed, Please try again";
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
}elseif ($status == "Delete") {
  include 'pages/view/config/dbconfig.php';
  if ($req_time == "08:00 AM") {
    $new_time_value = "Open";
    $time_label = "time8am";
  }
  if ($req_time =="09:00 AM") {
    $new_time_value = "Open";
    $time_label = "time9am";
  }

  if ($req_time =="10:00 AM") {
    $new_time_value = "Open";
    $time_label = "time10am";
  }

  if ($req_time =="11:00 AM") {
    $new_time_value = "Open";
    $time_label = "time11am";
  }

  if ($req_time =="01:00 PM") {
    $new_time_value = "Open";
    $time_label = "time1pm";
  }

  if ($req_time =="02:00 PM") {
    $new_time_value = "Open";
    $time_label = "time2pm";
  }

  if ($req_time =="03:00 PM") {
    $new_time_value = "Open";
    $time_label = "time3pm";
  }

  if ($req_time =="04:00 PM") {
    $new_time_value = "Open";
    $time_label = "time4pm";
  }

  if ($req_time =="05:00 PM") {
    $new_time_value = "Open";
    $time_label = "time5pm";
  }
  // echo $req_date."<br>";
  // echo $req_time."<br>";
  // echo $new_time_value."<br>";
  // echo $time_label;
  // echo "input_date = ".$req_date."<br>";
  // echo "label = ".$time_label."<br>";
  // echo "value = ".$new_time_value;
  // exit();
  $query2 = "UPDATE schedule
         SET $time_label = '$new_time_value'
         WHERE input_date = '$req_date'";
         $result2 = mysqli_query($conn, $query2 );
  if ($result2) {
    $sql = "DELETE FROM appointment_details WHERE appt_id = '$appt_approval_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $date_deleted = date("Y/m/d");
      $time_deleted = date("h:i a");
      $data_title = "Patient Appointment Record";
      $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
          VALUES ('$data_title', '$appt_approval_id', '$date_deleted', '$time_deleted', '$eml')";
       $result_delete = mysqli_query($conn, $query );
       if ($result_delete) {
         $msg =  'Record successfully deleted';
         $back = 2;
       }else{
         $msg =  'Failed to delete record, Please try again or contact website administrator';
         $back = 2;
       }
    }
  }else{
 
    $msg =  'Failed to delete record, Please try again or contact website administrator';
    $back = 2;
  }
  echo "<script>alert('$msg')</script>";
  echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
}elseif ($status == "View") {
  echo '<form id="view" action="../RHU/?p=updateappt" method="post">';
  echo '<input type="hidden" name="appt_id" value="'.$appt_approval_id.'">';
  echo '<input type=submit>';
  echo '<script>document.getElementById("view").submit();</script>';
}elseif ($status == "Edit") {
  echo '<form id="edit" action="../RHU/?p=updateappt" method="post">';
  echo '<input type="hidden" name="appt_id" value="'.$appt_approval_id.'">';
  echo '<input type=submit>';
  echo '<script>document.getElementById("edit").submit();</script>';
}else{
    include 'pages/view/config/dbconfig.php';
    $query = "UPDATE appointment_details
           SET status = '$status',
           act_date = '$act_date',
           act_time = '$act_time'
           WHERE appt_id = '$appt_approval_id'";
              //execute the query here
     $result = mysqli_query($conn, $query );
     if ($result) {
       $sql = "SELECT * FROM appointment_details WHERE appt_id = '$appt_approval_id'";
       $result2 = mysqli_query($conn, $sql );
       $appt_details = mysqli_fetch_assoc($result2);
       $patient_name = $appt_details["user_id"];
       $contact_no = $appt_details["contact_no"];
       $req_date = $appt_details["req_date"];
       $req_time = $appt_details["req_time"];
       $doctor = $appt_details["doctor"];
       
       

       $query = "INSERT INTO notification(notif_type, id, status, fullname,  notif_status, notif_link, user_type)
           VALUES ('Appointment', '$appt_approval_id', '$status', '$patient_name', '1', 'appt', '4')";
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


       $msg =  'Appointment has been '.$status;
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
    echo '<input type="hidden" name="message_type" value="appt">';
    echo '<input type="hidden" name="status" value="'.$status.'">';
    echo '<input type="hidden" name="req_date" value="'.$req_date.'">';
    echo '<input type="hidden" name="req_time" value="'.$req_time.'">';
    echo '<input type="hidden" name="doctor" value="'.$doctor_fullname.'">';
    echo '<input type="hidden" name="patient_name" value="'.$patient_fullname.'">';
    echo '<script>document.getElementById("notif").submit();</script>';
    }else{
    echo "<script>alert('$msg')</script>";
    echo "<script>window.history.back();</script>";
    }
}
 ?>
