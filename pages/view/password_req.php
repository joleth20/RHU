<?php
$eml_curr = $_SESSION["eml"];
$user_id_curr = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$reports_title = $_POST["reports_title"];
$reports_link = $_POST["reports_link"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
}

 ?>
   <div class="row">
       <div class="col-12 grid-margin">
         <div class="card">
           <div class="card-body">
                <h4>Admin Password is Required!</h4>
                <code>* You are trying to access <b><?php echo $reports_title;?></b></code>
                <div id="display_error"></div>
                <div class="col-lg-4">
                <form class="pt-3" action="../RHU/?p=password_req_p" method="POST" autocomplete="off">
                  <div class="form-group" >
                    <input type="password" class="form-control form-control-lg" id="pw" name="pw" placeholder="Enter Admin Password" required>
                  </div>
                 
                  <div class="mb-4">
                    <div class="form-check">
                      <label class="form-check-label text-muted">
                        <input type="checkbox" class="form-check-input" onclick="showHide()">Show Password </label>
                    </div>
                  </div>
                  <div class="mt-3 mb-3">
                    <input type="submit" id="sbmt_form" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn">
                    <button type="button" class="btn btn-block btn-info btn-lg font-weight-medium auth-form-btn" onclick="window.top.location.href='../RHU/?p=dashboard_a';">Cancel</button>
                  </div>
                    
                  <input type="hidden" name="un" value="<?php echo $eml_curr;?>">
                  <input type="hidden" name="reports_title" value="<?php echo $reports_title;?>">
                  <input type="hidden" name="reports_link" value="<?php echo $reports_link;?>">
                </form>
              </div>
           </div>
         </div>
       </div>
   </div>


    <!-- endinject -->
  </body>
</html>


<script>
    function showHide() {
      var pw = document.getElementById("pw");
      if (pw.type === "password" ) {
        pw.type = "text";
      } else {
        pw.type = "password";
      }
    }
</script>