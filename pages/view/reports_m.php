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
      echo '<input type="hidden" name="reports_title" value="Medication Refills Reports">';
      echo '<input type="hidden" name="reports_link" value="reports_m">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Medication Refills Reports">';
        echo '<input type="hidden" name="reports_link" value="reports_m">';
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
        <h4 class="card-title">Medication Refills Details</h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=reports_m_export" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('export_type').value='curr';this.form.submit();">Export to Excel (Current Month)</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('export_type').value='ytd';this.form.submit();">Export to Excel (YTD)</button>
        </div>
          <input type="hidden" id="export_type" name="export_type">
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> Rx ID </th>
                <th> Patient Name </th>
                <th> Birthday</th>
                <th> Age</th>
                <th> Gender</th>
                <th> Address</th>
                <th> Contact# </th>
                <th> PhilHealth </th>
                <th> Email </th>
                <th> Medicine Name </th>
                <th> Quantity </th>
                <th> Dosage </th>
                <th> Prescription </th>
                <th> Doctor </th>
                <th> Start Date </th>
                <th> End Date </th>
                <th> Date Request </th>
                <th> Time Request </th>
                <th> Action Date </th>
                <th> Action Time </th>
                <th> Status </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                $sql = "SELECT * FROM medication_refills";
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
                    
                    echo '<tr><td>'.$row["rx_id"].'</td>';
                    echo '<td>'.$row["fullname"].'</td>';
                    echo '<td>'.$row["bday"].'</td>';
                    echo '<td>'.$row["age"].'</td>';
                    echo '<td>'.$row["gender"].'</td>';
                    echo '<td>'.$row["address"].'</td>';
                    echo '<td>'.$row["contact_no"].'</td>';
                    echo '<td>'.$row["phealth"].'</td>';
                    echo '<td>'.$row["eml"].'</td>';
                    echo '<td>'.$row["rx_name"].'</td>';
                    echo '<td>'.$row["quantity"].'</td>';
                    echo '<td>'.$row["dosage"].'</td>';
                    echo '<td>'.$row["prescription"].'</td>';
                    echo '<td>'.$doctor_fullname.'</td>';
                    echo '<td>'.$row["start_date"].'</td>';
                    echo '<td>'.$row["end_date"].'</td>';
                    echo '<td>'.$row["req_date"].'</td>';
                    echo '<td>'.$row["req_time"].'</td>';
                    echo '<td>'.$row["act_date"].'</td>';
                    echo '<td>'.$row["act_time"].'</td>';
                    echo '<td>'.$row["status"].'</td></tr>';
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
