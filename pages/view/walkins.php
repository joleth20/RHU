<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];

if($user_type != "1"){
    echo "<script>alert('Action Not Allowed')</script>";
   echo "<script>window.top.location.href='../RHU/?p=login';</script>";
}


?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
          
       <div id="filter_pc">
          <form  action="../RHU/?p=walkins" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="appt_id")?"selected":"";?> value="appt_id">Appointment ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="services")?"selected":"";?> value="services">Services</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="concern")?"selected":"";?> value="concern">Concern</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>
                  </select>
              <input type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
              <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=walkins">Clear filter</a></label>
            </div>
          </form>
       </div>
       
       <div id="filter_mobile">
          <form  action="../RHU/?p=walkins" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text"  class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="appt_id")?"selected":"";?> value="appt_id">Appointment ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="services")?"selected":"";?> value="services">Services</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="concern")?"selected":"";?> value="concern">Concern</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>
                  </select>
              <input type="text"  class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
              <label class="form-control bg-transparent border-0 "><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=walkins"><i class="mdi mdi-close-circle"></i></a></label>
            </div>
          </form>
       </div>
        
        
        <h4 class="card-title">Walk-ins Summary</h4>
        <div class="btn-group" role="group" aria-label="Basic example">
          <!--<form action="../RHU/?p=appt" method="post" id="status_form">-->
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="window.top.location.href='../RHU/?p=newwalkins';">Add New Record</button>
        <!--  <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>-->
        <!--  <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>-->
        <!--  <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>-->
        <!--  <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>-->
        <!--</div>-->
        <!--<div class="form-group" id="status_filter_select">-->
            
        <!--      <div class="input-group">-->
        <!--            <i class="input-group-text border-0 mdi mdi-filter"></i>-->
        <!--            <select class="form-control form-control-lg" style="color:black" required onchange="document.getElementById('status_filter').value=this.value;this.form.submit();">-->
        <!--              <option disabled selected>--Select Status--</option>-->
        <!--              <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="All")?"selected":"";?> value="All" style="color:black">All</option>-->
        <!--              <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Pending")?"selected":"";?> value="Pending" style="color:black">Pending</option>-->
        <!--              <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Approved")?"selected":"";?> value="Approved" style="color:black">Approved</option>-->
        <!--              <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Rejected")?"selected":"";?> value="Rejected" style="color:black">Rejected</option>-->
        <!--              <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Completed")?"selected":"";?> value="Completed" style="color:black">Completed</option>-->
        <!--            </select>-->
        <!--            </div>-->
        <!--   </div>-->
        <!--  <input type="hidden" id="status_filter" name="status_filter">-->
        </div>
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> Appt.ID </th>
                <th> Patient Name </th>
                <th> Service </th>
                <th> Concern </th>
                <th> Date Requested</th>
                <th> Time Requested</th>
                <th> Status </th>
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
                    $sql = "SELECT * FROM appointment_details WHERE doctor = '$user_id' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM appointment_details WHERE walkin = '1' and $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE doctor = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE doctor = '$user_id' and status = '$status_filter'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM appointment_details WHERE walkin = '1'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM appointment_details WHERE walkin = '1' and status = '$status_filter'";
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
                        $sql = "SELECT * FROM appointment_details WHERE doctor = '$user_id'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM appointment_details WHERE walkin = '1'";
                      }else{
                        $sql = "SELECT * FROM appointment_details WHERE user_id = '$user_id'";
                      }
                    }
                }

                $result = mysqli_query($conn, $sql);
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
              
                  $patient_fullname = $row["fname"].' '.$row["mi"].' '.$row["lname"];
                  
                  echo '<tr><td>'.$row["appt_id"].'</td>';
                  echo '<td>'.$patient_fullname.'</td>';
                  echo '<td>'.$row["services"].'</td>';
                  echo '<td>'.$row["concern"].'</td>';
                  echo '<td>'.$row["req_date"].'</td>';
                  echo '<td>'.$row["req_time"].'</td>';
                  echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</label></td>';
                  if (($user_type == "1" || $user_type == "2" || $user_type == "3") ) {
                    if ($row["status"] == "Pending" ) {
                        echo '<td><form  action="../RHU/?p=apptapproval_p" method="post">';
                        echo '<input type="hidden" name="req_date" value="'.$row["req_date"].'">';
                        echo '<input type="hidden" name="req_time" value="'.$row["req_time"].'">';
                        echo '<input type="hidden" name="doctor" value="'.$row["doctor"].'">';
                        echo '<input type="hidden" name="appt_id" value="'.$row["appt_id"].'">';
                      ?>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='View';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Approve" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='Approved';this.form.submit();"><i class="mdi mdi-check"></i></button>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Reject" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='Rejected';this.form.submit();"><i class="mdi mdi-close" ></i></button>
                      <?php
                        echo '<input type="hidden" id="appt_approval'.$row["appt_id"].'" name="appt_approval">';
                        echo '<input type="hidden" name="appt_approval_id" value="'.$row["appt_id"].'"></form></td></tr>';
                    }elseif ($row["status"] == "Completed"  || $row["status"] == "Rejected") {
                       echo '<td><form  action="../RHU/?p=updatewalkins_p" method="post">';
                      ?>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('appt_walkins<?php echo $row["appt_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('appt_walkins<?php echo $row["appt_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                      <?php
                        echo '<input type="hidden" id="appt_walkins'.$row["appt_id"].'" name="walkins_type">';
                        echo '<input type="hidden" name="appt_id" value="'.$row["appt_id"].'"></form></td></tr>';
                    }else{
                      echo '<td><form  action="../RHU/?p=updateappt" method="post">';
                      echo '<input type="hidden" name="appt_id" value="'.$row["appt_id"].'">';
                      echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon"><i class="mdi mdi-pencil"></i></button></form></td></tr>';
                    }
                  }else {
                      if ($row["status"] == "Completed"  || $row["status"] == "Approved") {
                          echo '<td><form  action="../RHU/?p=updateappt" method="post">';
                          echo '<input type="hidden" name="appt_id" value="'.$row["appt_id"].'">';
                          echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon"><i class="mdi mdi-eye"></i></button></form></td></tr>';
                    }else{
                        echo '<td><form  action="../RHU/?p=apptapproval_p" method="post">';
                        echo '<input type="hidden" name="req_date" value="'.$row["req_date"].'">';
                        echo '<input type="hidden" name="req_time" value="'.$row["req_time"].'">';
                        echo '<input type="hidden" name="doctor" value="'.$row["doctor"].'">';
                        echo '<input type="hidden" name="appt_id" value="'.$row["appt_id"].'">';
                      ?>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                        <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('appt_approval<?php echo $row["appt_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                      <?php
                        echo '<input type="hidden" id="appt_approval'.$row["appt_id"].'" name="appt_approval">';
                        echo '<input type="hidden" name="appt_approval_id" value="'.$row["appt_id"].'"></form></td></tr>';
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

