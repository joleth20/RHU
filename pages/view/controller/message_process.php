<?php
session_start();
date_default_timezone_set('Asia/Manila');
$msg_id = $_POST["msg_id"];
$msg_value = $_POST["msg_value"];


if($msg_value == "View_Received"){
  include 'pages/view/config/dbconfig.php';
    $sql = "UPDATE message_details
       SET msg_status = 'Read'
       WHERE msg_id = '$msg_id'";
    $result = mysqli_query($conn, $sql);
  if($result){
      echo '<form id="view" action="../RHU/?p=viewmessage" method="post">';
      echo '<input type="hidden" name="msg_id" value="'.$msg_id.'">';
      echo '<script>document.getElementById("view").submit();</script>';
  }
  
}elseif($msg_value == "View_Sent"){
    echo '<form id="view" action="../RHU/?p=viewmessage" method="post">';
    echo '<input type="hidden" name="msg_id" value="'.$msg_id.'">';
    echo '<input type="hidden" name="view_sent" value="view_sent">';
    echo '<script>document.getElementById("view").submit();</script>';
}elseif($msg_value == "Delete_Received"){
    $delete_received = "1";
    include 'pages/view/config/dbconfig.php';
    $sql = "UPDATE message_details
       SET delete_received = '$delete_received'
       WHERE msg_id = '$msg_id'";
    $result = mysqli_query($conn, $sql);
    if($result){
         $back == 1;
         $msg = "Message Deleted";
     }else{
         $back == 2;
         $msg = "Failed to Delete message, please contact your website administrator.";

     }
}elseif($msg_value == "Delete_Sent"){
    $delete_sent = "1";
    include 'pages/view/config/dbconfig.php';
    $sql = "UPDATE message_details
       SET delete_sent = '$delete_sent'
       WHERE msg_id = '$msg_id'";
    $result = mysqli_query($conn, $sql);
    if($result){
         $back == 1;
         $msg = "Message Deleted";
     }else{
         $back == 2;
         $msg = "Failed to Delete message, please contact your website administrator.";

     }
}elseif($msg_value == "Reply"){
    $received_by = $_POST["received_by"];
    include 'pages/view/config/dbconfig.php';
    $sql2 = "SELECT * FROM user_details WHERE CONCAT(`fname`, ' ', `mi`, ' ', `lname`) = '$received_by'";
    $result2 = mysqli_query($conn, $sql2);
    $user_details = mysqli_fetch_assoc($result2);
    $profile_pic_receivedby = $user_details["profile_pic"];
    $profile_pic_sentby = $_SESSION["profile_pic"];
    

    
    $msg_title = $_POST["msg_title"];
    $msg_content = $_POST["msg_content"];
    $msg_status = "Unread";
    $sent_by = $_POST["sent_by"];
    $date_received = date("Y-m-d");
    $time_received = date("h:i a");
    $replied = "1";
    $replied_to = $_POST["replied_to"];
    $delete_sent = "0";
    $delete_received = "0";
    include 'pages/view/config/dbconfig.php';
    $query = "INSERT INTO message_details (profile_pic_sentby, profile_pic_receivedby, msg_title, msg_content, msg_status, sent_by,  received_by, date_received, time_received, replied, replied_to, delete_sent, delete_received)
        VALUES ('$profile_pic_sentby', '$profile_pic_receivedby', '$msg_title', '$msg_content', '$msg_status','$sent_by', '$received_by',  '$date_received', '$time_received', '$replied', '$replied_to', '$delete_sent', '$delete_received')";
     $result = mysqli_query($conn, $query );
     if($result){
         $back == 1;
         $msg = "Message Sent";
     }else{
         $back == 2;
         $msg = "Failed to send message, please contact your website administrator.";
     }
         
}elseif($msg_value == "New"){
    $received_by = $_POST["received_by"];
    include 'pages/view/config/dbconfig.php';
    $sql2 = "SELECT * FROM user_details WHERE CONCAT(`fname`, ' ', `mi`, ' ', `lname`) = '$received_by'";
    $result2 = mysqli_query($conn, $sql2);
    $user_details = mysqli_fetch_assoc($result2);
    $profile_pic_receivedby = $user_details["profile_pic"];
    $profile_pic_sentby = $_SESSION["profile_pic"];

    $msg_title = $_POST["msg_title"];
    $msg_content = $_POST["msg_content"];
    $msg_status = "Unread";
    $sent_by = $_POST["sent_by"];
    
    $date_received = date("Y-m-d");
    $time_received = date("h:i a");
    $delete_sent = "0";
    $delete_received = "0";
    $query = "INSERT INTO message_details (profile_pic_sentby, profile_pic_receivedby, msg_title, msg_content, msg_status, sent_by,  received_by, date_received, time_received, delete_sent, delete_received)
        VALUES ('$profile_pic_sentby', '$profile_pic_receivedby', '$msg_title', '$msg_content', '$msg_status','$sent_by', '$received_by',  '$date_received', '$time_received','$delete_sent', '$delete_received')";
     $result = mysqli_query($conn, $query );
     if($result){
         $back = 1;
         $msg = "Message Sent";
     }else{
         $back = 2;
         $msg = "Failed to send message, please contact your website administrator.";
     }
}

 if ($back == 1) {
    echo "<script>alert('$msg')</script>";
    echo "<script>window.top.location.href='../RHU/?p=message';</script>";
 }else{
    echo "<script>alert('$msg')</script>";
    echo "<script>window.top.location.href='../RHU/?p=message';</script>";
 }

?>