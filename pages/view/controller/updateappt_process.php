<?php
session_start();
$user_type = $_SESSION['user_type'];
// echo '<pre>';
// var_dump($_SESSION);
// echo '</pre>';


//appointment details
$appt_id = $_POST["appt_id"];
$req_date = $_POST["req_date"];
$req_time = $_POST["req_time"];
$services = $_POST["services"];
$concern = $_POST["concern"];
$other_concern = $_POST["other_concern"];
$doctor = $_POST["doctor"];
$curr_req_time = $_POST["curr_req_time"];
$curr_req_date = $_POST["curr_req_date"];
$curr_doctor = $_POST["curr_doctor"];


//vital Details
$vdate = $_POST["vdate"];
$weight = $_POST["weight"];
$height = $_POST["height"];
$bp = $_POST["bp"];
$pulse_rate = $_POST["pulse_rate"];
$temp = $_POST["temp"];
$oxy_sat = $_POST["oxy_sat"];
$findings = $_POST["findings"];
$status = $_POST["status"];


// echo $curr_req_date."<br>";
// echo $curr_req_time."<br>";
// echo $req_date."<br>";
// echo $req_time."<br>";
include 'pages/view/config/dbconfig.php';
if ($status == "Approved") {
   
  if ($user_type == "3") {
    $status = "Approved";
  }else{
    $status = "Completed";
     
  }
  //updating vitals
  $query = "UPDATE appointment_details
         SET vdate = '$vdate',
         weight = '$weight',
         height = '$height',
         bp = '$bp',
         pulse_rate = '$pulse_rate',
         temp = '$temp',
         oxy_sat = '$oxy_sat',
         findings = '$findings',
         status = '$status'
         WHERE appt_id = '$appt_id'";
     $result = mysqli_query($conn, $query );
     if($result){
          $msg =  "Record Updated";
         $back = 1;
     }else {
         $msg =  "Failed to update record, Please try again or contact website administrator";
         $back = 2;
     }
}else{
    //updating pending appt
    $query = "UPDATE appointment_details
           SET req_date = '$req_date',
           req_time = '$req_time',
           services = '$services',
           concern = '$concern',
           other_concern = '$other_concern',
           doctor = '$doctor',
           status = 'Pending'
           WHERE appt_id = '$appt_id'";
              //execute the query here

     $result = mysqli_query($conn, $query );
       //DELETE OLD REQ DATE AND TIME AND CHANGE THE TIME SLOT TO OPEN
       if ($curr_req_date != $req_date || $curr_req_time != $req_time) {
     
         if ($curr_req_time =="08:00 AM") {
           $curr_time_value = "Open";
           $time_label = "time8am";
         }
         if ($curr_req_time =="09:00 AM") {
           $curr_time_value = "Open";
           $time_label = "time9am";
         }

         if ($curr_req_time =="10:00 AM") {
           $curr_time_value = "Open";
           $time_label = "time10am";
         }

         if ($curr_req_time =="11:00 AM") {
           $curr_time_value = "Open";
           $time_label = "time11am";
         }

         if ($curr_req_time =="01:00 PM") {
           $curr_time_value = "Open";
           $time_label = "time1pm";
         }

         if ($curr_req_time =="02:00 PM") {
           $curr_time_value = "Open";
           $time_label = "time2pm";
         }

         if ($curr_req_time =="03:00 PM") {
           $curr_time_value = "Open";
           $time_label = "time3pm";
         }

         if ($curr_req_time =="04:00 PM") {
           $curr_time_value = "Open";
           $time_label = "time4pm";
         }

         if ($curr_req_time =="05:00 PM") {
           $curr_time_value = "Open";
           $time_label = "time5pm";
         }
       // echo $curr_req_date."<br>";
       // echo $curr_req_time."<br>";
       // echo $curr_time_value."<br>";
       // echo $time_label;
       
      

         include 'pages/view/config/dbconfig.php';
         if($curr_doctor == $doctor ){
             $query = "UPDATE schedule
                     SET $time_label = '$curr_time_value'
                     WHERE input_date = '$curr_req_date' and user_id = '$doctor'";
                 
         }else{
             $query = "UPDATE schedule
                     SET $time_label = '$curr_time_value'
                     WHERE input_date = '$curr_req_date' and user_id = '$curr_doctor'";
         }        
                 $result = mysqli_query($conn, $query );
                 if ($result) {
                   if ($req_time =="08:00 AM") {
                     $new_time_value = "Booked";
                     $time_label = "time8am";
                   }
                   if ($req_time =="09:00 AM") {
                     $new_time_value = "Booked";
                     $time_label = "time9am";
                   }

                   if ($req_time =="10:00 AM") {
                     $new_time_value = "Booked";
                     $time_label = "time10am";
                   }

                   if ($req_time =="11:00 AM") {
                     $new_time_value = "Booked";
                     $time_label = "time11am";
                   }

                   if ($req_time =="01:00 PM") {
                     $new_time_value = "Booked";
                     $time_label = "time1pm";
                   }

                   if ($req_time =="02:00 PM") {
                     $new_time_value = "Booked";
                     $time_label = "time2pm";
                   }

                   if ($req_time =="03:00 PM") {
                     $new_time_value = "Booked";
                     $time_label = "time3pm";
                   }

                   if ($req_time =="04:00 PM") {
                     $new_time_value = "Booked";
                     $time_label = "time4pm";
                   }

                   if ($req_time =="05:00 PM") {
                     $new_time_value = "Booked";
                     $time_label = "time5pm";
                   }
                   // echo $req_date."<br>";
                   // echo $req_time."<br>";
                   // echo $new_time_value."<br>";
                   // echo $time_label;
                   $query2 = "UPDATE schedule
                          SET $time_label = '$new_time_value'
                          WHERE input_date = '$req_date' and user_id = '$doctor'";
                          $result2 = mysqli_query($conn, $query2 );
                 }else{
                    //  echo mysqli_errno()."_--".mysqli_error()."<br /> in query.:".$query;
                    $msg =  "Failed to update record, Please try again or contact website administrator";
                    $back = 2;
                    echo mysqli_error($conn);
                    exit();
                 }

     

         $msg =  "Record Updated";
         $back = 1;
     }
 
     else {
         $msg =  "Failed to update record, Please try again or contact website administrator";
         $back = 2;
     }

}
if ($back == 1) {
echo "<script>alert('$msg')</script>";
echo "<script>window.top.location.href='../RHU/?p=appt';</script>";
}else{
echo "<script>alert('$msg')</script>";
echo "<script>window.history.back();</script>";
}
 ?>
