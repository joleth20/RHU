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
      echo '<input type="hidden" name="reports_title" value="Doctors Reports">';
      echo '<input type="hidden" name="reports_link" value="reports_d">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Doctors Reports">';
        echo '<input type="hidden" name="reports_link" value="reports_d">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      } 
    }

}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="search-field d-none d-md-block">
          <!-- <form  action="../RHU/?p=rx" method="POST">
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
          </form> -->
        </div>
        <h4 class="card-title">Doctor Details</h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=reports_d_export" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('export_type').value='curr';this.form.submit();">Export to Excel (Current Month)</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('export_type').value='ytd';this.form.submit();">Export to Excel (YTD)</button>
        </div>
          <input type="hidden" id="export_type" name="export_type">
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> User ID </th>
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
                <th> Services </th>
                <th> Email </th>
                <th> Date Registered </th>
                <th> Time Registered </th>
                <th> Verified </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                $sql = "SELECT * FROM user_details WHERE user_type = '2'";
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{

                  while($row=mysqli_fetch_assoc($result)){
                    $verified = ($row["verified"] == 1)?"yes":"no";
                    echo '<tr><td>'.$row["user_id"].'</td>';
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
                    echo '<td>'.$row["services"].'</td>';
                    echo '<td>'.$row["eml"].'</td>';
                    echo '<td>'.$row["date_registered"].'</td>';
                    echo '<td>'.$row["time_registered"].'</td>';
                    echo '<td>'.$verified.'</td></tr>';

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
