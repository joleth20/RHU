<?php
$sender = $_SESSION["user_id"];
$msg_id = $_POST["msg_id"];
include 'pages/view/db/dbconfig.php';
$sql = "SELECT * FROM message_details WHERE msg_id = $msg_id";
$result = mysqli_query($conn, $sql);
$msg_details = mysqli_fetch_assoc($result);
$msg_title = $msg_details["msg_title"];
$msg_content = $msg_details["msg_content"];


$sent_by = $msg_details["sent_by"];
$sql_sentBy = "SELECT * FROM user_details WHERE user_id = '$sent_by'";
$result_sentBy = mysqli_query($conn, $sql_sentBy);
$user_sentBy = mysqli_fetch_assoc($result_sentBy);
$sentBy_fullname = $user_sentBy["fname"]." ".$user_sentBy["mi"]." ".$user_sentBy["lname"];

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
   <h4>You're replying to:</h4>
     <div class="form-group" >
       <h6 class="font-weight-light">Sender</h6>
       <input type="text" class="form-control form-control-lg"  readonly value="<?php echo $sentBy_fullname;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Subject</h6>
       <input type="text" class="form-control form-control-lg"  readonly value="<?php echo $msg_title;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Message Content</h6>
       <textarea class="form-control form-control-lg" readonly style="height:200px"><?php echo $msg_content;?></textarea>
     </div>

  

   <h4>Your Message Details</h4>
   <form class="pt-3" action="../RHU/?p=message_p" method="POST" autocomplete="off">
     <div class="form-group" >
       <h6 class="font-weight-light">Send To:</h6>
       <input type="text" class="form-control form-control-lg" readonly value="<?php echo $sentBy_fullname;?>">
       <input type="hidden" id="received_by" name="received_by" value="<?php echo $sent_by;?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Subject</h6>
       <input type="text" class="form-control form-control-lg"  id="msg_title" name="msg_title" value="Re: <?php echo $msg_title;?>" readonly>
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">Message Content</h6>
       <textarea class="form-control form-control-lg" id="msg_content" name="msg_content" required style="height:200px"></textarea>
     </div>
     <div class="input-group">
     <div class="mt-3">
       <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" value="Send">
     </div>&nbsp;
     <div class="mt-3">
       <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=message';">Cancel</button>
     </div>
     </div>
    <input type="hidden" name="replied_to" value="<?php echo $msg_id;?>">
    <input type="hidden" name="sent_by" value="<?php echo $sender;?>">
    <input type="hidden" name="msg_value" value="Reply">
   </form>
    </div>
 </div>
 
 <script>

 </script>
