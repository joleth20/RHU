<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";
}else{
  if($_SESSION["password_req"] != "ON"){
      echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
      echo '<input type="hidden" name="reports_title" value="Deletion Log">';
      echo '<input type="hidden" name="reports_link" value="deletion_log">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Deletion Log">';
        echo '<input type="hidden" name="reports_link" value="deletion_log">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      } 
    }
}
?>

<div class="row">
 <h4 class="card-title">Deletion Log</h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=deletion_log_p" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('export_type').value='excel';this.form.submit();">Export to Excel</button>
          <!--<button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('export_type').value='pdf';this.form.submit();">Export to PDF</button>-->
        </div>
          <input type="hidden" id="export_type" name="export_type">
        </form>
</div>

