<?php
session_start();
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';

//patient user_details
$user_id = $_SESSION["user_id"];
$fname = $_SESSION["fname"];
$mi = $_SESSION["mi"];
$lname = $_SESSION["lname"];
$age = $_SESSION["age"];
$full_name = $fname." ".$mi." ".$lname;
$gender = $_SESSION["gender"];
$bday = $_SESSION["bday"];
$user_type = $_SESSION["user_type"];
$address_stblc = $_SESSION["address_stblc"];
$address_brgy = $_SESSION["address_brgy"];
$address_city = $_SESSION["address_city"];
$contact_no = $_SESSION["contact_no"];
$phealth = $_SESSION["phealth"];
$eml = $_SESSION["eml"];

//appointment details
$req_date = $_POST["req_date"];
$req_time = $_POST["req_time"];
$services = $_POST["services"];
$concern = $_POST["concern"];
$other_concern = $_POST["other_concern"];
$doctor = $_POST["doctor"];
$status = "Pending";

//Schedule
if ($req_time == "08:00 AM") {
  $time_value = "Booked";
  $time_label = "time8am";
}
if ($req_time == "09:00 AM") {
  $time_value = "Booked";
  $time_label = "time9am";
}

if ($req_time == "10:00 AM") {
  $time_value = "Booked";
  $time_label = "time10am";
}

if ($req_time == "11:00 AM") {
  $time_value = "Booked";
  $time_label = "time11am";
}

if ($req_time == "01:00 PM") {
  $time_value = "Booked";
  $time_label = "time1pm";
}

if ($req_time == "02:00 PM") {
  $time_value = "Booked";
  $time_label = "time2pm";
}

if ($req_time == "03:00 PM") {
  $time_value = "Booked";
  $time_label = "time3pm";
}

if ($req_time == "04:00 PM") {
  $time_value = "Booked";
  $time_label = "time4pm";
}

if ($req_time == "05:00 PM") {
  $time_value = "Booked";
  $time_label = "time5pm";
}

// echo $services."<br>";
// echo $concern."<br>";
// echo $doctor."<br>";
// echo $req_date."<br>";
// echo $time_label."<br>";
// echo $time_value."<br>";




include 'pages/view/config/dbconfig.php';
$query = "INSERT INTO appointment_details(user_id, fname, mi, lname,  age, gender, bday, address_stblc, address_brgy, address_city, contact_no, phealth, eml, req_date, req_time, services, concern, other_concern, doctor, status)
    VALUES ('$user_id', '$fname', '$mi', '$lname','$age', '$gender',  '$bday', '$address_stblc', '$address_brgy', '$address_city','$contact_no', '$phealth', '$eml', '$req_date','$req_time',
       '$services', '$concern', '$other_concern', '$doctor', '$status')";
 $result = mysqli_query($conn, $query );
 $appt_id = $conn->insert_id;

 if ($result) {
     //updating doctor's schedule
     $query = "UPDATE schedule
            SET $time_label = '$time_value'
            WHERE input_date = '$req_date'";
      $result2 = mysqli_query($conn, $query);

      //SMS notification details
     $sql = "SELECT * FROM user_details";
     $result2 = mysqli_query($conn, $sql);
     while($row=mysqli_fetch_assoc($result2)){
       if ($row["user_type"] == "2") {
         $doctor_user_id = $row["user_id"];
         if ($doctor_user_id == $doctor) {
           $contact_no = $row["contact_no"];
         }
       }
     }


     $query = "INSERT INTO notification(notif_type, id, status, fullname,  notif_status, notif_link, user_type)
         VALUES ('Appointment', '$appt_id', '$status', '$doctor', '1', 'appt', '2')";
      $result = mysqli_query($conn, $query );

     $msg =  "New Appointment has been created successfully";
     $back = 1;
     $_SESSION["eml"] = $eml;
     $_SESSION["verified"] = "0";
 }
 else {
     $msg =  "Failed to add new appointment, Please try again or contact website administrator";
     $back = 2;
 }
 if ($back == 1) {
 echo "<script>alert('$msg')</script>";
//  echo '<form id="notif" action="../RHU/?p=notify" method="post">';
//  echo '<input type="hidden" name="number" value="'.$contact_no.'">';
//  echo '<input type="hidden" name="message_type" value="appt">';
//  echo '<input type="hidden" name="status" value="'.$status.'">';
//  echo '<input type="hidden" name="req_date" value="'.$req_date.'">';
//  echo '<input type="hidden" name="req_time" value="'.$req_time.'">';
//  echo '<script>document.getElementById("notif").submit();</script>';
 echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
 }else{
 echo "<script>alert('$msg')</script>";
 echo "<script>window.history.back();</script>";
 }
 ?>
