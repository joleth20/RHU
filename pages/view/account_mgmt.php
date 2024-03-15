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
      echo '<input type="hidden" name="reports_title" value="Add New Account">';
      echo '<input type="hidden" name="reports_link" value="new_account">';
      echo '<script>document.getElementById("password_req").submit();</script>';
  }else{
    if( $_SESSION['last_activity'] < time()-$_SESSION['expire_time'] ) {
        unset($_SESSION['password_req']);
        echo '<form id="password_req" action="../RHU/?p=password_req" method="post">';
        echo '<input type="hidden" name="reports_title" value="Add New Account">';
        echo '<input type="hidden" name="reports_link" value="new_account">';
        echo '<script>document.getElementById("password_req").submit();</script>';
      }
    }

}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
          
        <div id="filter_pc">
          <form  action="../RHU/?p=account_mgmt" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="user_id")?"selected":"";?> value="user_id">User ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="eml")?"selected":"";?> value="eml">Email</option>
                  </select>
                <input type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=account_mgmt" title="Clear">Clear filter</a></label>
            </div>
          </form>
       </div>
       
       <div id="filter_mobile">
          <form  action="../RHU/?p=account_mgmt" method="POST">
             <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  <select type="text"  class="form-control bg-transparent " placeholder="Search projects" name="search_by" >
                    <option selected disabled>Search By...</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="user_id")?"selected":"";?> value="user_id">User ID</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="fname")?"selected":"";?> value="fname">First Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="lname")?"selected":"";?> value="lname">Last Name</option>
                    <option <?php echo (isset($_POST["search_by"]) && $_POST["search_by"]=="eml")?"selected":"";?> value="eml">Email</option>
                  </select></div>
                   <div class="input-group">
                <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();" value="<?php echo (isset($_POST["search"]))?$_POST["search"]:""; ?>">
                <label><a class="form-control bg-transparent border-0 text-muted" href="../RHU/?p=account_mgmt"><i class="mdi mdi-close-circle"></i></a></label>  </div>
          
          </form>
       </div>
        
        <h4 class="card-title">Account Management</h4>
        <div id="status_filter_button" class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=account_mgmt" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='4';this.form.submit();">Patient</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='3';this.form.submit();">Receptionist</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='2';this.form.submit();">Doctor</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='1';this.form.submit();">Admin</button>
        </div>
        <div class="form-group" id="status_filter_select">
              <div class="input-group">
                    <i class="input-group-text border-0 mdi mdi-filter"></i>
                    <select class="form-control form-control-lg" style="color:black" required onchange="document.getElementById('status_filter').value=this.value;this.form.submit();">
                      <option disabled selected>--Select Status--</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="All")?"selected":"";?> value="All" style="color:black">All</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="4")?"selected":"";?> value="4" style="color:black">Patient</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="3")?"selected":"";?> value="3" style="color:black">Receptionist</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="2")?"selected":"";?> value="2" style="color:black">Doctor</option>
                      <option <?php echo (isset($_POST["status_filter"]) && $_POST["status_filter"]=="1")?"selected":"";?> value="1" style="color:black">Admin</option>
                    </select>
            </div>
           </div>
          <input type="hidden" id="status_filter" name="status_filter">
        </form>
        <div class="table-responsive">
          <table class="table" id="rhu_table">
            <thead>
              <tr>
                <th> User ID </th>
                <th> Firstname </th>
                <th> MI </th>
                <th> Lastname</th>
                <th> Contact# </th>
                <th> PhilHealth </th>
                <th> Email </th>
                <th> Date Registered </th>
                <th> Time Registered </th>
                <th> Verified </th>
                <th> Action </th>
              </tr>
            </thead>
            <tbody>

                <?php
                include 'pages/view/config/dbconfig.php';
                if (isset($_POST["search"])) {
                  $search = $_POST["search"];
                  $search_by = $_POST["search_by"];
                  if ($user_type == 2) {
                    $sql = "SELECT * FROM user_details WHERE doctor = '$doctor_fullname' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM user_details WHERE $search_by LIKE '%$search%'";
                  }
                }else {
                    if (isset($_POST["status_filter"])) {
                      if ($user_type == "2") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM user_details WHERE doctor = '$doctor_fullname'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM user_details WHERE doctor = '$doctor_fullname' and status = '$status_filter'";
                        }
                      }elseif ($user_type == "1" || $user_type == "3") {
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM user_details";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM user_details WHERE user_type = '$status_filter'";
                        }
                      }else{
                        if ($_POST["status_filter"] == "All") {
                          $sql = "SELECT * FROM user_details WHERE user_id = '$user_id'";
                        }else{
                          $status_filter = $_POST["status_filter"];
                          $sql = "SELECT * FROM user_details WHERE user_id = '$user_id' and status = '$status_filter'";
                        }
                      }

                    }else{
                      if ($user_type == "2") {
                        $sql = "SELECT * FROM user_details WHERE doctor = '$doctor_fullname' and status = 'Pending'";
                      }elseif ($user_type == "1" || $user_type == "3") {
                        $sql = "SELECT * FROM user_details";
                      }else{
                        $sql = "SELECT * FROM user_details WHERE user_id = '$user_id' and status = 'Pending'";
                      }
                    }
                }
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
                    echo '<td>'.$row["contact_no"].'</td>';
                    echo '<td>'.$row["phealth"].'</td>';
                    echo '<td>'.$row["eml"].'</td>';
                    echo '<td>'.$row["date_registered"].'</td>';
                    echo '<td>'.$row["time_registered"].'</td>';
                    echo '<td>'.$verified.'</td>';
                    echo '<td><form  action="../RHU/?p=account_mgmt_p" method="post">';
                    echo '<input type="hidden" name="date_registered" value="'.$row["date_registered"].'">';
                    echo '<input type="hidden" name="time_registered" value="'.$row["time_registered"].'">';
                    echo '<input type="hidden" name="user_id" value="'.$row["user_id"].'">';
                  ?>
                    <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('user_approval<?php echo $row["user_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                    <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Change Password" onclick="document.getElementById('user_approval<?php echo $row["user_id"];?>').value='Reset';this.form.submit();"><i class="mdi mdi-key"></i></button>
                    <button class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('user_approval<?php echo $row["user_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                  <?php
                    echo '<input type="hidden" id="user_approval'.$row["user_id"].'" name="user_approval">';
                    echo '<input type="hidden" id="eml" name="eml" value="'.$row["eml"].'">';
                    echo '<input type="hidden" name="user_approval_id" value="'.$row["user_id"].'"></form></td></tr>';
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
