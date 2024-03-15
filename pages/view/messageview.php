<?php
$msg_id = $_POST["msg_id"];
include 'pages/view/db/dbconfig.php';
$sql = "SELECT * FROM message_details WHERE msg_id = $msg_id";
$result = mysqli_query($conn, $sql);
$msg_details = mysqli_fetch_assoc($result);
$msg_content = $msg_details["msg_content"];
$msg_title = $msg_details["msg_title"];
$replied = $msg_details["replied"];
$replied_to = $msg_details["replied_to"];
 ?>
<div class="page-header">
  <h3 class="page-title">
    <span class="page-title-icon bg-primary text-white me-2">
      <i class="mdi mdi-message-text"></i>
    </span> View Message
  </h3>
  <nav aria-label="breadcrumb">
    <!-- <ul class="breadcrumb">
      <li class="breadcrumb-item active" aria-current="page">
        <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
      </li>
    </ul> -->
    <button onclick="location.href = '../RHU/?p=message';" class="btn btn-info btn-rounded btn-icon">
      <i class="mdi mdi-close"></i>
    </button>
  </nav>
</div>
 <div class="col-lg-4">
 <div class="auth-form-light text-left p-5">
    <?php 
    
    if($replied == "1"){
        $sql2 = "SELECT * FROM message_details WHERE msg_id = $replied_to";
        $result2 = mysqli_query($conn, $sql2);
        if($result2){
            
        
        $replied_details = mysqli_fetch_assoc($result2);
        $replied_sender = $replied_details["sent_by"];
        $replied_subject = $replied_details["msg_title"];
        $replied_content = $replied_details["msg_content"];
        
        $sent_by1 = $replied_details["sent_by"];
        $sql_sentBy1 = "SELECT * FROM user_details WHERE user_id = '$sent_by1'";
        $result_sentBy1 = mysqli_query($conn, $sql_sentBy1);
        $user_sentBy = mysqli_fetch_assoc($result_sentBy1);
        $replied_sender = $user_sentBy["fname"]." ".$user_sentBy["mi"]." ".$user_sentBy["lname"];
        
        
    
    ?>
   <h4>Message Reference:</h4>
     <div class="form-group" >
       <h6 class="font-weight-light">Sender</h6>
       <input type="text" class="form-control form-control-lg"  readonly value="<?php echo $replied_sender;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Subject</h6>
       <input type="text" class="form-control form-control-lg"  readonly value="<?php echo $replied_subject;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Message Content</h6>
       <textarea class="form-control form-control-lg" readonly style="height:200px"><?php echo $replied_content;?></textarea>
     </div>
    <?php }}?>
    
    <?php
        $sent_by = $msg_details["sent_by"];
        $sql_sentBy = "SELECT * FROM user_details WHERE user_id = '$sent_by'";
        $result_sentBy = mysqli_query($conn, $sql_sentBy);
        $user_sentBy = mysqli_fetch_assoc($result_sentBy);
        $sentBy_fullname = $user_sentBy["fname"]." ".$user_sentBy["mi"]." ".$user_sentBy["lname"];
    ?>
   <h4>Message Details</h4>
   <form class="pt-3" action="../RHU/?p=replymessage" method="POST" autocomplete="off">
     <div class="form-group" >
       <h6 class="font-weight-light">Sender</h6>
       <input type="text" class="form-control form-control-lg" readonly value="<?php echo $sentBy_fullname;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Subject</h6>
       <input type="text" class="form-control form-control-lg" readonly value="<?php echo $msg_title;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Message Content</h6>
       <textarea class="form-control form-control-lg" id="sms_content" name="sms_content" readonly style="height:200px"><?php echo $msg_content;?></textarea>
     </div>
     <?php
        if(!isset($_POST["view_sent"])){?>
        <div class="input-group">
         <div class="mt-3">
           <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" value="Reply">
         </div>&nbsp;
         <div class="mt-3">
           <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=message';">Cancel</button>
         </div>
         </div>
    <?php }?>
    <input type="hidden" name="msg_id" value="<?php echo $msg_id;?>">
   </form>
   </div>
 </div>
