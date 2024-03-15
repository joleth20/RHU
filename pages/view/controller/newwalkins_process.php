<?php

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
if(!empty($_POST["req_time"])){
$req_time = $_POST["req_time"];
$req_time = DateTime::createFromFormat('H:i', $req_time);
$req_time = $req_time->format('h:i A');
}else{
    $req_time = "";
}

$user_id = $fname.$mi.$lname;

//vitals
$vdate = $_POST["vdate"];
$weight = $_POST["weight"];
$height = $_POST["height"];
$bp = $_POST["bp"];
$pulse_rate = $_POST["pulse_rate"];
$temp = $_POST["temp"];
$oxy_sat = $_POST["oxy_sat"];
$findings = $_POST["findings"];
$status = "Completed";
$walkin = "1";



include 'pages/view/config/dbconfig.php';
$query = "INSERT INTO appointment_details(user_id, fname, mi, lname,  age, gender, bday, address_stblc, address_brgy, address_city, contact_no, phealth, eml, req_date, req_time, services, concern, other_concern, doctor, status, vdate, weight, height, bp, pulse_rate, temp, oxy_sat, findings, walkin)
    VALUES ('$user_id', '$fname', '$mi', '$lname','$age', '$gender',  '$bday', '$address_stblc', '$address_brgy', '$address_city','$contact_no', '$phealth', '$eml', '$req_date','$req_time', '$services', '$concern', '$other_concern', '$doctor', '$status', '$vdate', '$weight', '$height', '$bp', '$pulse_rate', '$temp', '$oxy_sat', '$findings','$walkin')";
 $result = mysqli_query($conn, $query );
//  $appt_id = $conn->insert_id;

 if ($result) {
     $msg =  "New record added";
     $back = 1;
 }
 else {
     $msg =  "Failed to add record, Please try again or contact website administrator";
     $back = 2;
 }

 if ($back == 1) {
 echo "<script>alert('$msg')</script>";
 echo "<script>window.top.location.href='../RHU/?p=walkins';</script>";
 }else{
 echo "<script>alert('$msg')</script>";
 echo "<script>window.history.back();</script>";
 }

?>