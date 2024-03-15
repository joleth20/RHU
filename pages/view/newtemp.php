<?php
$user_type = $_SESSION["user_type"];
if ($user_type != "2") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}

 ?>
<div class="row">
<div class="col-12 grid-margin">
<div class="card">
<div class="card-body">
 <div class="col-lg-4">
   <h4>Add New SMS Template</h4>
   <form class="pt-3" action="../RHU/?p=newtemplate_p" method="POST" autocomplete="off">
     <div class="form-group" >
       <h6 class="font-weight-light">Title</h6>
       <input type="text" class="form-control form-control-lg" id="sms_title" name="sms_title" placeholder="Template Title..." required>
     </div>
     <div class="form-group" >
       <h6 class="font-weight-light">SMS Content</h6>
       <textarea class="form-control form-control-lg" id="sms_content" name="sms_content" placeholder="Your SMS content here..." required style="height:200px"></textarea>
     </div>
     <div class="input-group">
      <div class="mt-3">
        <input type="submit" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
      </div>&nbsp;
      <div class="mt-3">
        <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=smstemplate';">Cancel</button>
      </div>
    </div>

   </form>
 </div>
</div>
</div>
</div>
</div>
