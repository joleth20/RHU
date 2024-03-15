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
          <form  action="../RHU/?p=rx" method="POST">
              <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" id="search_by" name="search_by">
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_id")?"selected":"";?> value="rx_id">Medicine ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fullname")?"selected":"";?> value="fullname">Patient Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_name")?"selected":"";?> value="rx_name">Medicine Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>
                  </select>
                  <input type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Enter Keyword" id="search" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                  <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=rx">Clear filter</a></label>
             </div>
          </form>
         </div>
         <div id="filter_mobile">
          <form  action="../RHU/?p=rx" method="POST" >
              <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text" class="form-control" placeholder="Search projects" id="search_by" name="search_by">
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_id")?"selected":"";?> value="rx_id">Medicine ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fullname")?"selected":"";?> value="fullname">Patient Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="rx_name")?"selected":"";?> value="rx_name">Medicine Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="status")?"selected":"";?> value="status">Status</option>
                  </select></div>
               <div class="input-group">
                  <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                  <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=rx"><i class="mdi mdi-close-circle"></i></a></label></div>
               
          </form>
         </div>
    
      
        <h4 class="card-title">Medication Refills Summary</h4>
        <div id="status_filter_button" class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=rx" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>
        </div>
        <div class="form-group" id="status_filter_select">
           <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-filter"></i>
                    <select class="form-control form-control-lg" style="color:black" required onchange="document.getElementById('status_filter').value=this.value;this.form.submit();">
                      <option disabled selected>--Select Status--</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="All")?"selected":"";?> value="All" style="color:black">All</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Pending")?"selected":"";?> value="Pending" style="color:black">Pending</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Approved")?"selected":"";?> value="Approved" style="color:black">Approved</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Rejected")?"selected":"";?> value="Rejected" style="color:black">Rejected</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="Completed")?"selected":"";?> value="Completed" style="color:black">Completed</option>
                    </select>
             </div>
           </div>
          <input type="hidden" id="status_filter" name="status_filter">
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> Medicine ID </th>
                <th> Patient Name </th>
                <th> Medicine </th>
                <th> Receipt</th>
                <th> Date Requested</th>
                <th> Time Requested</th>
                <th> Action Date</th>
                <th> Action Time</th>
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
                    $sql = "SELECT * FROM medication_refills WHERE doctor = '$user_id' and $search_by LIKE '%$search%'";
                  }elseif ($user_type == 1 || $user_type == 3) {
                    $sql = "SELECT * FROM medication_refills WHERE $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id' and $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM medication_refills WHERE doctor = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM medication_refills WHERE doctor = '$user_id' and status = '$status_filter'";
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
                        $sql = "SELECT * FROM medication_refills WHERE doctor = '$user_id'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM medication_refills";
                      }else{
                        $sql = "SELECT * FROM medication_refills WHERE user_id = '$user_id'";
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
                
                  $patient_user_id = $row["user_id"];
                  $sql2 = "SELECT * FROM user_details WHERE user_id = '$patient_user_id'";
                  $result2 = mysqli_query($conn, $sql2);
                  if($result2->num_rows != 0){
                    $user_details = mysqli_fetch_assoc($result2);
                    $patient_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
                  }else{
                     $patient_fullname = $row["fullname"]; 
                  }
                 
                    
                    echo '<tr><td>'.$row["rx_id"].'</td>';
                    echo '<td>'.$patient_fullname.'</td>';
                    echo '<td>'.$row["rx_name"].'</td>';
                    echo '<td><a href="../RHU/assets/images/receipt/'.$row["prescription"].'" target="_blank">View Receipt</a></td>';
                    echo '<td>'.$row["req_date"].'</td>';
                    echo '<td>'.$row["req_time"].'</td>';
                    echo '<td>'.$row["act_date"].'</td>';
                    echo '<td>'.$row["act_time"].'</td>';
                    echo '<td><label class="badge badge-'.$status.'">'.$row["status"].'</label></td>';
                    if (($user_type == "1") ) {
                      if ($row["status"] == "Pending" ) {
                          echo '<td><form  action="../RHU/?p=rxapproval_p" method="post">';
                          echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        ?>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='View';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Approve" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Approved';this.form.submit();"><i class="mdi mdi-check"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Reject" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Rejected';this.form.submit();"><i class="mdi mdi-close" ></i></button>
                        <?php
                          echo '<input type="hidden" id="rx_approval'.$row["rx_id"].'" name="rx_approval">';
                          echo '<input type="hidden" id="user_id" name="user_id" value="'.$row["user_id"].'">';
                          echo '<input type="hidden" name="rx_approval_id" value="'.$row["rx_id"].'"></form></td></tr>';
                      }elseif ($row["status"] == "Rejected" || $row["status"] == "Approved") {
                          echo '<td><form  action="../RHU/?p=rxapproval_p" method="post">';
                          echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        ?>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='View';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                        
                        <?php
                          echo '<input type="hidden" id="rx_approval'.$row["rx_id"].'" name="rx_approval">';
                          echo '<input type="hidden" id="user_id" name="user_id" value="'.$row["user_id"].'">';
                          echo '<input type="hidden" name="rx_approval_id" value="'.$row["rx_id"].'"></form></td></tr>';
                      }elseif ($row["status"] == "Completed") {
                        echo '<td><form  action="../RHU/?p=updaterx" method="post">';
                        echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon" title="View"><i class="mdi mdi-eye"></i></button></form></td></tr>';
                      }else{
                        echo '<td><form  action="../RHU/?p=updaterx" method="post">';
                        echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit"><i class="mdi mdi-eye"></i></button></form></td></tr>';
                      }
                      //doctor/recep
                    }elseif (($user_type == "2" || $user_type == "3") ) {
                      if ($row["status"] == "Pending" ) {
                          echo '<td><form  action="../RHU/?p=rxapproval_p" method="post">';
                          echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        ?>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="View" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='View';this.form.submit();"><i class="mdi mdi-eye"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Approve" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Approved';this.form.submit();"><i class="mdi mdi-check"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Reject" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Rejected';this.form.submit();"><i class="mdi mdi-close" ></i></button>
                        <?php
                          echo '<input type="hidden" id="rx_approval'.$row["rx_id"].'" name="rx_approval">';
                          echo '<input type="hidden" id="user_id" name="user_id" value="'.$row["user_id"].'">';
                          echo '<input type="hidden" name="rx_approval_id" value="'.$row["rx_id"].'"></form></td></tr>';
                      }elseif ($row["status"] == "Completed" || $row["status"] == "Rejected") {
                        echo '<td><form  action="../RHU/?p=updaterx" method="post">';
                        echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon" title="View"><i class="mdi mdi-eye"></i></button></form></td></tr>';
                      }else{
                        echo '<td><form  action="../RHU/?p=updaterx" method="post">';
                        echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit"><i class="mdi mdi-pencil"></i></button></form></td></tr>';
                      }
                    }else {
                        if ($row["status"] == "Completed" || $row["status"] == "Approved") {
                        echo '<td><form  action="../RHU/?p=updaterx" method="post">';
                        echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon" title="View"><i class="mdi mdi-eye"></i></button></form></td></tr>';
                      }else{
                        echo '<td><form  action="../RHU/?p=rxapproval_p" method="post">';
                          echo '<input type="hidden" name="rx_id" value="'.$row["rx_id"].'">';
                        ?>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                          <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('rx_approval<?php echo $row["rx_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                        <?php
                          echo '<input type="hidden" id="rx_approval'.$row["rx_id"].'" name="rx_approval">';
                          echo '<input type="hidden" id="user_id" name="user_id" value="'.$row["user_id"].'">';
                          echo '<input type="hidden" name="rx_approval_id" value="'.$row["rx_id"].'"></form></td></tr>';
                      }
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
