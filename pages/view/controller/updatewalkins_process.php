<?php
session_start();
if(isset($_POST["walkins_type"])){
    $walkins_type = $_POST["walkins_type"];
    $appt_id = $_POST["appt_id"];
}else{
   echo "<script>alert('Action Not Allowed!')</script>";
   echo "<script>window.top.location.href='../RHU/?p=login';</script>";
}

if($walkins_type == "Edit"){
  echo '<form id="edit" action="../RHU/?p=updatewalkins" method="post">';
  echo '<input type="hidden" name="appt_id" value="'.$appt_id.'">';
  echo '<script>document.getElementById("edit").submit();</script>';
}elseif($walkins_type == "Delete"){
    $eml = $_SESSION["eml"];
    include 'pages/view/config/dbconfig.php';
    $sql = "DELETE FROM appointment_details WHERE appt_id = '$appt_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
      $date_deleted = date("Y/m/d");
      $time_deleted = date("h:i a");
      $data_title = "Walk-in Patient Consultation Record";
      $query = "INSERT INTO data_deletion_log(data_title, data_id, date_deleted, time_deleted, deleted_by)
          VALUES ('$data_title', '$appt_id', '$date_deleted', '$time_deleted', '$eml')";
       $result_delete = mysqli_query($conn, $query );
       if ($result_delete) {
         echo "<script>alert('Record Deleted!')</script>";
         echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
       }else{
         echo "<script>alert('Failed to Delete Record, Please contact your website administrator!')</script>";
         echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
       }
    }else{
        echo "<script>alert('Failed to Delete Record, Please contact your website administrator!')</script>";
        echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
    }
}elseif($walkins_type == "Update"){

//patient information
$fname = $_POST["fname"];
$mi = $_POST["mi"];
$lname = $_POST["lname"];
$bday = $_POST["bday"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$address_stblc = $_POST["address_stblc"];
$address_brgy = $_POST["address_brgy"];
$address_city = $_POST["address_city"];
$contact_no = $_POST["contact_no"];
$eml = $_POST["eml"];
$phealth = $_POST["phealth"];

//services
$services = $_POST["services"];
$concern = $_POST["concern"];
$other_concern = $_POST["other_concern"];
$doctor = $_POST["doctor"];
$req_date = $_POST["req_date"];
$req_time = $_POST["req_time"];
$req_time = DateTime::createFromFormat('H:i', $req_time);
$req_time = $req_time->format('h:i A');

//vitals
$vdate = $_POST["vdate"];
$weight = $_POST["weight"];
$height = $_POST["height"];
$bp = $_POST["bp"];
$pulse_rate = $_POST["pulse_rate"];
$temp = $_POST["temp"];
$oxy_sat = $_POST["oxy_sat"];
$findings = $_POST["findings"];

  include 'pages/view/config/dbconfig.php';
  $query = "UPDATE appointment_details
         SET fname = '$fname',
         mi = '$mi',
         lname = '$lname',
         bday = '$bday',
         age = '$age',
         gender = '$gender',
         address_stblc = '$address_stblc',
         address_brgy = '$address_brgy',
         address_city = '$address_city',
         contact_no = '$contact_no',
         eml = '$eml',
         phealth = '$phealth',
         services = '$services',
         concern = '$concern',
         other_concern = '$other_concern',
         doctor = '$doctor',
         req_date = '$req_date',
         req_time = '$req_time',
         vdate = '$vdate',
         weight = '$weight',
         height = '$height',
         bp = '$bp',
         pulse_rate = '$pulse_rate',
         temp = '$temp',
         oxy_sat = '$oxy_sat',
         findings = '$findings'
         WHERE appt_id = '$appt_id'";
     $result = mysqli_query($conn, $query );
     if($result){
        echo "<script>alert('Record Updated!')</script>";
        echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
     }else{
        echo "<script>alert('Failed to Update Record, Please contact your website administrator.')</script>";
        echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
     }
}



?>