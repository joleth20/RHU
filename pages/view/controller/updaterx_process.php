<?php
session_start();
$user_type = $_SESSION['user_type'];
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


//appointment details
$rx_id = $_POST["rx_id"];
$rx_name = $_POST["rx_name"];
$quantity = $_POST["quantity"];
$dosage = $_POST["dosage"];
$prescription_backup = $_POST["prescription_backup"];
$file_prescription = $_FILES["prescription"]["name"];
$file_prescription = basename($file_prescription);
if ($file_prescription == "") {
  $file_prescription = $prescription_backup;
  $upload = 0;
}else {
  $file_prescription = basename($file_prescription);
  $upload = 1;
}

$doctor = $_POST["doctor"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$status = $_POST["status"];
$findings = $_POST["findings"];


include 'pages/view/config/dbconfig.php';
if ($status == "Approved") {
  if ($user_type == "3") {
    $status = "Approved";
  }else{
    $status = "Completed";
  }
  //updating vitals
  $query = "UPDATE medication_refills
         SET status = '$status',
         findings = '$findings'
         WHERE rx_id = '$rx_id'";
}else{
    //updating pending appt
    $query = "UPDATE medication_refills
           SET rx_name = '$rx_name',
           quantity = '$quantity',
           dosage = '$dosage',
           prescription = '$file_prescription',
           doctor = '$doctor',
           start_date = '$start_date',
           end_date = '$end_date',
           status = 'Pending'
           WHERE rx_id = '$rx_id'";
              //execute the query here
}
     $result = mysqli_query($conn, $query );
     if ($result) {
         if ($upload == 1) {
           $target_dir = "../RHU/assets/images/receipt/";
           $target_file = $target_dir . $file_prescription;
           $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
           move_uploaded_file($_FILES["prescription"]["tmp_name"], $target_file);
         }
         $msg =  "Record Updated";
         $back = 1;
     }
     else {
         $msg =  "Failed to update record, Please try again or contact website administrator";
         $back = 2;
     }


if ($back == 1) {
echo "<script>alert('$msg')</script>";
echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
}else{
echo "<script>alert('$msg')</script>";
echo "<script>window.history.back();</script>";
}
 ?>
