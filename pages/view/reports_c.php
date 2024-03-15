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
      echo '<input type="hidden" name="reports_title" value="Consultation Reports">';
      echo '<input type="hidden" name="reports_link" value="reports_c">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Consultation Reports">';
        echo '<input type="hidden" name="reports_link" value="reports_c">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      } 
    }
}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <!-- <div class="search-field d-none d-md-block">
          <form  action="../RHU/?p=rx" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">
                <option selected disabled>Search By...</option>
                <option value="rx_id">Medecine ID</option>
                <option value="fullname">Patient Name</option>
                <option value="rx_name">Medicine</option>
                <option value="status">Status</option>
              </select>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();">
            </div>
          </form>
        </div> -->
        <h4 class="card-title">Consultation Details</h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=reports_c_export" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('export_type').value='curr';this.form.submit();">Export to Excel (Current Month)</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('export_type').value='ytd';this.form.submit();">Export to Excel (YTD)</button>
        </div>
          <input type="hidden" id="export_type" name="export_type">
        </form>
        <div class="table-responsive">
          <table class="table table-bordered" id="rhu_table">
            <thead>
              <tr>
                <th> Appt. ID </th>
                <th> Firstname </th>
                <th> MI </th>
                <th> Lastname</th>
                <th> Birthday</th>
                <th> Age</th>
                <th> Gender</th>
                <th> Address stblc</th>
                <th> Barangay </th>
                <th> City </th>
                <th> Contact# </th>
                <th> PhilHealth </th>
                <th> Email </th>
                <th> Vital Date </th>
                <th> Weight </th>
                <th> Height </th>
                <th> BP </th>
                <th> Pulse Rate </th>
                <th> Temperature </th>
                <th> Oxygen Saturation </th>
                <th> Findings </th>
                <th> Request Date </th>
                <th> Request Time </th>
                <th> Action Date </th>
                <th> Action Time </th>
                <th> Services </th>
                <th> Concern </th>
                <th> Other Concern </th>
                <th> Doctor </th>
                <th> Status </th>
                <th> Walk-in? </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                $sql = "SELECT * FROM appointment_details";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                    $doctor_user_id = $row["doctor"];
                    $sql2 = "SELECT * FROM user_details WHERE user_id = '$doctor_user_id'";
                    $result2 = mysqli_query($conn, $sql2);
                    $user_details = mysqli_fetch_assoc($result2);
                    $doctor_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
                    
                    
                    if($row["walkin"] == "1"){
                        $walkin = "Yes";
                    }else{
                        $walkin = "No";
                    }
                    
                    echo '<tr><td>'.$row["appt_id"].'</td>';
                    echo '<td>'.$row["fname"].'</td>';
                    echo '<td>'.$row["mi"].'</td>';
                    echo '<td>'.$row["lname"].'</td>';
                    echo '<td>'.$row["bday"].'</td>';
                    echo '<td>'.$row["age"].'</td>';
                    echo '<td>'.$row["gender"].'</td>';
                    echo '<td>'.$row["address_stblc"].'</td>';
                    echo '<td>'.$row["address_brgy"].'</td>';
                    echo '<td>'.$row["address_city"].'</td>';
                    echo '<td>'.$row["contact_no"].'</td>';
                    echo '<td>'.$row["phealth"].'</td>';
                    echo '<td>'.$row["eml"].'</td>';
                    echo '<td>'.$row["vdate"].'</td>';
                    echo '<td>'.$row["weight"].'</td>';
                    echo '<td>'.$row["height"].'</td>';
                    echo '<td>'.$row["bp"].'</td>';
                    echo '<td>'.$row["pulse_rate"].'</td>';
                    echo '<td>'.$row["temp"].'</td>';
                    echo '<td>'.$row["oxy_sat"].'</td>';
                    echo '<td>'.$row["findings"].'</td>';
                    echo '<td>'.$row["req_date"].'</td>';
                    echo '<td>'.$row["req_time"].'</td>';
                    echo '<td>'.$row["act_date"].'</td>';
                    echo '<td>'.$row["act_time"].'</td>';
                    echo '<td>'.$row["services"].'</td>';
                    echo '<td>'.$row["concern"].'</td>';
                    echo '<td>'.$row["other_concern"].'</td>';
                    echo '<td>'.$doctor_fullname.'</td>';
                    echo '<td>'.$row["status"].'</td>';
                    echo '<td>'.$walkin.'</td>';
                  }
                }

                ?>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="assets/js/script.js"></script>
