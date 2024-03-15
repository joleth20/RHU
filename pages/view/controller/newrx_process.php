<?php
session_start();




//patient Details
$user_id = $_SESSION["user_id"];
$fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
$age = $_SESSION["age"];
$bday = $_SESSION["bday"];
$gender = $_SESSION["gender"];
$address = $_SESSION["address_stblc"]." ".$_SESSION["address_brgy"]." ".$_SESSION["address_city"];
$contact_no = $_SESSION["contact_no"];
$eml = $_SESSION["eml"];
$phealth = $_SESSION["phealth"];
$user_type = $_SESSION["user_type"];
//rx details
$rx_name = $_POST["rx_name"];
$quantity = $_POST["quantity"];
$dosage = $_POST["dosage"];
$file_prescription = $_FILES["prescription"]["name"];
$file_prescription = basename($file_prescription);
$doctor = $_POST["doctor"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$req_date = date("Y-m-d");
$req_time = date("h:i a");
$status = "Pending";



//
//
//
// echo $rx_name."<br>";
// echo $quantity."<br>";
// echo $dosage."<br>";
// echo $doctor."<br>";
// echo $start_date."<br>";
// echo $end_date."<br>";
// echo $file_prescription;
// Check if image file is a actual image or fake image
// if(isset($_POST["rx_name"])) {
//   $check = getimagesize($_FILES["prescription"]["tmp_name"]);
//   echo $check;
//   if($check !== false) {
//     echo "File is an image - " . $check["mime"] . ".";
//     $uploadOk = 1;
//   } else {
//     echo "File is not an image.";
//     $uploadOk = 0;
//   }
// }


include 'pages/view/config/dbconfig.php';
$query = "INSERT INTO medication_refills(user_id, fullname, age, bday, gender, address, contact_no, eml, phealth, rx_name, quantity, dosage, prescription, doctor, start_date, end_date, req_date, req_time, status)
    VALUES ('$user_id', '$fullname', '$age', '$bday', '$gender', '$address','$contact_no', '$eml',  '$phealth', '$rx_name', '$quantity', '$dosage', '$file_prescription','$doctor', '$start_date',  '$end_date', '$req_date', '$req_time', '$status')";
 $result = mysqli_query($conn, $query );
 $rx_id = $conn->insert_id;
 if ($result) {
   $target_dir = "../RHU/assets/images/receipt/";
   $target_file = $target_dir . $file_prescription;
   $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   move_uploaded_file($_FILES["prescription"]["tmp_name"], $target_file);

   $sql = "SELECT * FROM user_details";
   $result2 = mysqli_query($conn, $sql);
   while($row=mysqli_fetch_assoc($result2)){
     if ($row["user_type"] == "2") {
       $doctor_fullname = $row["fname"]." ".$row["mi"]." ".$row["lname"];
       if ($doctor_fullname == $doctor) {
         $contact_no = $row["contact_no"];
       }
     }
   }
   
    $query = "INSERT INTO notification(notif_type, id, status, fullname,  notif_status, notif_link, user_type)
     VALUES ('Medication Refills', '$rx_id', '$status', '$doctor', '1', 'rx', '2')";
  $result = mysqli_query($conn, $query );
   
   
   $msg =  "New Medication Refills request has been created successfully";
   $back = 1;
 }else {
   $msg =  "Failed to add new medication refills refills, Please try again or contact website administrator";
   $back = 2;
 }

 if ($back == 1) {
 echo "<script>alert('$msg')</script>";
//  echo '<form id="notif" action="../RHU/?p=notify" method="post">';
//  echo '<input type="hidden" name="number" value="'.$contact_no.'">';
//  echo '<input type="hidden" name="message_type" value="rx">';
//  echo '<input type="hidden" name="status" value="'.$status.'">';
//  echo '<input type="hidden" name="req_date" value="'.$req_date.'">';
//  echo '<input type="hidden" name="req_time" value="'.$req_time.'">';
//  echo '<script>document.getElementById("notif").submit();</script>';
echo "<script>window.top.location.href='../RHU/?p=rx';</script>";
 }else{
 echo "<script>alert('$msg')</script>";
 echo "<script>window.history.back();</script>";
 }


 ?>
