<?php
$sms_value = $_POST["sms_value"];
$patient_name = $_POST["patient_name"];
$contact_no = $_POST["contact_no"];

if($sms_value == "Info"){
   echo '<form id="patient_summary" action="../RHU/?p=analytics_p" method="post">';
   echo '<input type="hidden" name="user_id" value="'.$_POST["user_id"].'">';
   echo '<script>document.getElementById("patient_summary").submit();</script>';
}else{
  if (isset($_POST["sms_title"])) {
      $sms_title = $_POST["sms_title"];
      include 'pages/view/config/dbconfig.php';
      $sql = "SELECT * FROM sms_template WHERE sms_title = '$sms_title'";
      $result = mysqli_query($conn, $sql);
      $sms_details = mysqli_fetch_assoc($result);
      $sms_content = $sms_details["sms_content"];
      $msg = "SMS Sent!";
      echo "<script>alert('$msg')</script>";
      echo '<form id="send_sms" action="../RHU/?p=notify" method="post">';
      echo '<input type="hidden" name="number" value="'.$contact_no.'">';
      echo '<input type="hidden" name="message_type" value="sms_template">';
      echo '<input type="hidden" name="sms_content" value="'.$sms_content.'">';
      echo '<input type="hidden" name="patient_name" value="'.$patient_name.'">';
      echo '<script>document.getElementById("send_sms").submit();</script>';
    }else{
      $msg = "Failed to send SMS! Please select SMS Message Template";
      echo "<script>alert('$msg')</script>";
      echo "<script>window.top.location.href='../RHU/?p=patient_records';</script>";
    }
}



 ?>
