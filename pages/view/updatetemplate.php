<?php
$user_type = $_SESSION["user_type"];
$sms_id = $_POST["sms_id"];
if ($user_type != "2") {
  echo "<script>alert('You are not allowed to access this page.')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}

include 'pages/view/config/dbconfig.php';
$sql = "SELECT * FROM sms_template WHERE sms_id = '$sms_id'";
$result = mysqli_query($conn, $sql);
$sms_details = mysqli_fetch_assoc($result);

 ?>
<div class="row">
<div class="col-12 grid-margin">
<div class="card">
<div class="card-body">
 <div class="col-lg-4">
   <h4>Update SMS Template</h4>
   <form class="pt-3" action="../RHU/?p=updatetemplate_p" method="POST" autocomplete="off">
     <div class="form-group" >
       <h6 class="font-weight-light">Title</h6>
       <input type="text" class="form-control form-control-lg" id="sms_title" name="sms_title" placeholder="Template Title..." required value="<?php echo $sms_details["sms_title"];?>">
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">SMS Content</h6>
       <textarea class="form-control form-control-lg" id="sms_content" name="sms_content" placeholder="Your SMS content here..." required style="height:200px"><?php echo $sms_details["sms_content"];?></textarea>
     </div>
     <div class="input-group">
      <div class="mt-3">
        <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
      </div>&nbsp;
      <div class="mt-3">
        <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=smstemplate';">Cancel</button>
      </div>
    </div>
     <input type="hidden" name="sms_id" value="<?php echo $sms_id;?>">
   </form>
 </div>
</div>
</div>
</div>
</div>
