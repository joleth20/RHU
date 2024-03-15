<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "1") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="search-field d-none d-md-block">
          <form  action="../RHU/?p=rx_reminder" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">
                <option selected disabled>Search By...</option>
                <option value="rx_id">Medicine ID</option>
                <option value="fullname">Patient Name</option>
                <option value="rx_name">Medicine</option>
              </select>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();">
            </div>
          </form>
        </div>
        <h4 class="card-title">Medication Refills Reminder</h4>
        <!-- <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=rx" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>
        </div>
          <input type="hidden" id="status_filter" name="status_filter">
        </form> -->
        <div class="table-responsive">
          <table class="table" id="rx_table">
            <thead>
              <tr>
                <th> Rx ID </th>
                <th> Patient Name </th>
                <th> Medicine </th>
                <th> Receipt</th>
                <th> Start Date</th>
                <th> End Date</th>
                <th> Remaining Days </th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if ($user_type == 2) {
                    $sql = "SELECT * FROM medication_refills WHERE doctor = '$doctor_fullname' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM medication_refills WHERE $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM medication_refills WHERE doctor = '$doctor_fullname'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM medication_refills WHERE doctor = '$doctor_fullname' and status = '$status_filter'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM medication_refills";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM medication_refills WHERE status = '$status_filter'";
                        }
                      }else{
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and status = '$status_filter'";
                        }
                      }

                    }else{
                      if ($user_type == "2") {
                        $sql = "SELECT * FROM medication_refills WHERE doctor = '$doctor_fullname' and status = 'Pending'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM medication_refills WHERE (status = 'Completed' || status = 'Approved') and end_date >= CURDATE()";
                      }else{
                        $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and status = 'Pending'";
                      }
                    }
                }
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                    if ($row["status"] == "Pending") {
                      $status = "warning";
                    }elseif ($row["status"] == "Completed") {
                      $status = "info";
                    }elseif ($row["status"] == "Approved") {
                      $status = "success";
                    }else{
                      $status = "danger";
                    }

                    $datenow = date('Y-m-d');
                    $end_date = $row["end_date"];
                    $date1 = new DateTime($datenow);  //current date or any date
                    $date2 = new DateTime($end_date);   //Future date
                    $diff = $date2->diff($date1)->format("%a");  //find difference
                    $days_remaining = intval($diff);   //rounding days
                    if ($days_remaining <= 2) {
                      $status_color = "danger";
                    }else{
                      $status_color = "info";
                    }
                    echo '<tr><td>'.$row["rx_id"].'</td>';
                    echo '<td>'.$row["fullname"].'</td>';
                    echo '<td>'.$row["rx_name"].'</td>';
                    echo '<td><a href="../RHU/assets/images/receipt/'.$row["prescription"].'" target="_blank">View Receipt</a></td>';
                    echo '<td>'.$row["start_date"].'</td>';
                    echo '<td>'.$row["end_date"].'</td>';
                    echo '<td><label class="badge badge-'.$status_color.'">'.$days_remaining.' day(s) remaining</label></td>';
                    if ($days_remaining <=2) {
                      echo '<form id="send_reminder" action="../RHU/?p=notify" method="post">';
                      echo '<input type="hidden" name="number" value="'.$row["contact_no"].'">';
                      echo '<input type="hidden" name="message_type" value="reminder">';
                      echo '<input type="hidden" name="patient_name" value="'.$row["fullname"].'">';
                      echo '<input type="hidden" name="rx_name" value="'.$row["rx_name"].'">';
                      echo '<input type="hidden" name="days_remaining" value="'.$days_remaining.'">';
                      echo '<td><button class="btn btn-info btn-sm" onclick="this.form.submit();">Send Reminder</button></td></tr>';
                    }


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
