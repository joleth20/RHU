<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];

?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
          
       <div id="filter_pc">
          <form  action="../RHU/?p=patient_records" method="POST">
            <div class="input-group">
              <i class="input-group-text border-0 mdi mdi-magnify"></i>
              <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">
                <option selected disabled>Search By...</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="eml")?"selected":"";?> value="eml">Email</option>
              </select>
              <input type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
              <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=patient_records">Clear filter</a></label>
            </div>
          </form>
       </div>
       
       <div id="filter_mobile">
          <form  action="../RHU/?p=patient_records" method="POST">
            <div class="input-group">
              <i class="input-group-text border-0 mdi mdi-magnify"></i>
              <select type="text" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">
                <option selected disabled>Search By...</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="eml")?"selected":"";?> value="eml">Email</option>
              </select></div>
              <div class="input-group">
              <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
              <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=patient_records"><i class="mdi mdi-close-circle"></i></a></label>
            </div>
          </form>
       </div>
        
        
        <h4 class="card-title">Patient Records</h4>
        <!-- <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=appt" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>
        </div>
          <input type="hidden" id="status_filter" name="status_filter">
        </form> -->
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> Patient Name </th>
                <th> Age </th>
                <th> Gender </th>
                <th> Birthday</th>
                <th> Contact#</th>
                <th> Email</th>
                <th> PhilHealth</th>
                <th> SMS Message Title </th>
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
                    // $sql = "SELECT * FROM appointment_details WHERE doctor = '$user_id' and $search_by LIKE '%$search%' and status = 'Completed'";
                    $sql = "SELECT max(appt_id) as appt_id, 
                        max(fname) as fname,
                        max(mi) as mi,
                        max(lname) as lname,
                        max(age) as age,
                        max(gender)as gender,
                        max(bday) as bday,
                        max(contact_no) as contact_no,
                        max(phealth) as phealth,
                        max(eml) as eml,
                        max(user_id) as user_id 
                        FROM appointment_details 
                        WHERE doctor = '$user_id' AND status = 'Completed'  AND $search_by LIKE '%$search%'
                        GROUP BY user_id";
                  }else{
                    $sql = "SELECT * FROM appointment_details WHERE status = 'Completed' and $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and status = '$status_filter'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE status = '$status_filter'";
                        }
                      }else{
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and status = '$status_filter'";
                        }
                      }

                    }else{
                      if ($user_type == "2") {
                        $sql = "SELECT max(appt_id) as appt_id, 
                        max(fname) as fname,
                        max(mi) as mi,
                        max(lname) as lname,
                        max(age) as age,
                        max(gender)as gender,
                        max(bday) as bday,
                        max(contact_no) as contact_no,
                        max(phealth) as phealth,
                        max(eml) as eml,
                        max(user_id) as user_id 
                        FROM appointment_details 
                        WHERE doctor = '$user_id' AND status = 'Completed' 
                        GROUP BY user_id";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM appointment_details WHERE status = 'Pending'";
                      }else{
                        $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id' and status = 'Pending'";
                      }
                    }
                }

                $result = mysqli_query($conn, $sql);
                echo mysqli_error($conn);
                if($result){
                    
                while($row=mysqli_fetch_assoc($result)){
                  $patient_name = $row["fname"].' '.$row["mi"].' '.$row["lname"];
                  echo '<tr>';
                  echo '<td>'.$patient_name.'</td>';
                  echo '<td>'.$row["age"].'</td>';
                  echo '<td>'.$row["gender"].'</td>';
                  echo '<td>'.$row["bday"].'</td>';
                  echo '<td>'.$row["contact_no"].'</td>';
                  echo '<td>'.$row["eml"].'</td>';
                  echo '<td>'.$row["phealth"].'</td>';
                  $sql1 = "SELECT * FROM sms_template";
                  $result1 = mysqli_query($conn, $sql1);
                  echo '<form  action="../RHU/?p=patient_records_p" method="post">';
                  echo '<td><select name="sms_title" class="form-control form-control-lg" required>';
                  echo '<option disabled selected>--Select SMS Template--</option>';
                  while($row1=mysqli_fetch_assoc($result1)){
                    echo '<option>'.$row1["sms_title"].'</option>';
                  }
                  echo '</select></td><td>';
                  echo '<input type="hidden" name="patient_name" value="'.$patient_name.'">';
                  echo '<input type="hidden" name="contact_no" value="'.$row["contact_no"].'">';
                  echo '<input type="hidden" name="user_id" value="'.$row["user_id"].'">';
                ?>
                  <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Send SMS" onclick="document.getElementById('sms_title<?php echo $row["appt_id"];?>').value='Send';this.form.submit();"><i class="mdi mdi-send"></i></button>
                  <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Patient Summary" onclick="document.getElementById('sms_title<?php echo $row["appt_id"];?>').value='Info';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                <?php
                  echo '<input type="hidden" id="sms_title'.$row["appt_id"].'" name="sms_value">';
                  echo '</form></td></tr>';
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
