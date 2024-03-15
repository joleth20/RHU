<?php
$user_id = $_SESSION["user_id"];
$user_type = $_SESSION["user_type"];
$doctor_fullname = $_SESSION["fname"]." ".$_SESSION["mi"]." ".$_SESSION["lname"];
if ($user_type != "2") {
  echo "<script>alert('Action Not Allowed!')</script>";
  echo "<script>window.top.location.href='../RHU/?p=dashboard';</script>";

}
?>

<div class="row">
  <div class="col-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="search-field d-none d-md-block">
          <form  action="../RHU/?p=schedule" method="POST">
            <div class="input-group">
                <i class="input-group-text border-0 mdi mdi-magnify"></i>
              <select type="text" style="max-width:11%" class="form-control bg-transparent border-0" placeholder="Search projects" name="search_by">
                <option selected disabled>Search By...</option>
                <option value="sched_id">Schedule ID</option>
                <option value="fullname">Doctor</option>
              </select>
              <input type="text" class="form-control bg-transparent border-0" placeholder="Enter Keyword" name="search" onchange="this.form.submit();">
            </div>
          </form>
        </div>
        <h4 class="card-title">Schedule Summary</h4>
        <!-- <div class="btn-group" role="group" aria-label="Basic example">
          <form action="../RHU/?p=rx" method="post">
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_all" onclick="document.getElementById('status_filter').value='All';this.form.submit();">All</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info"id="status_pending" onclick="document.getElementById('status_filter').value='Pending';this.form.submit();">Pending</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_approved" onclick="document.getElementById('status_filter').value='Approved';this.form.submit();">Approved</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_rejected" onclick="document.getElementById('status_filter').value='Rejected';this.form.submit();">Rejected</button>
          <button type="button" class="btn btn-outline-secondary badge badge-info" id="status_completed" onclick="document.getElementById('status_filter').value='Completed';this.form.submit();">Completed</button>
        </div> -->
          <input type="hidden" id="status_filter" name="status_filter">
        </form>
        <div class="table-responsive">
          <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">

          <table class="table table-hover" id="rhu_table" style="max-width:60%;">
            <thead>
              <tr>
                <th> Schedule ID </th>
                <th> Doctor </th>
                <th> Date </th>
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
                    $sql = "SELECT * FROM schedule WHERE user_id = '$user_id' and $search_by LIKE '%$search%'";
                  }else{
                    $sql = "SELECT * FROM schedule WHERE $search_by LIKE '%$search%'";
                  }
                }else {
                        $sql = "SELECT * FROM schedule WHERE user_id = '$user_id' AND input_date >= ADDDATE(CURDATE(),1) ORDER BY input_date";
                }
                $result = mysqli_query($conn, $sql);
                if ($result->num_rows == 0) {
                    echo "No records found!";
                }else{
                  while($row=mysqli_fetch_assoc($result)){
                      $doctor_user_id = $row["user_id"];
                      $sql2 = "SELECT * FROM user_details WHERE user_id = '$doctor_user_id'";
                      $result2 = mysqli_query($conn, $sql2);
                      $user_details = mysqli_fetch_assoc($result2);
                      $doctor_fullname = $user_details["fname"].' '.$user_details["mi"].' '.$user_details["lname"];
                      
                      
                      
                    echo '<tr><td>'.$row["sched_id"].'</td>';
                    echo '<td>'.$doctor_fullname.'</td>';
                    echo '<td>'.$row["input_date"].'</td>';

                    if (($user_type == "1" || $user_type == "2" || $user_type == "3") ) {

                          echo '<td><form action="../RHU/?p=sched_p" method="post">';
                          echo '<input type="hidden" name="sched_id" value="'.$row["sched_id"].'">';
                        ?>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Edit" onclick="document.getElementById('sched_value<?php echo $row["sched_id"];?>').value='Edit';this.form.submit();"><i class="mdi mdi-pencil"></i></button>
                          <button  class="btn btn-inverse-primary btn-rounded btn-icon" title="Delete" onclick="document.getElementById('sched_value<?php echo $row["sched_id"];?>').value='Delete';this.form.submit();"><i class="mdi mdi-delete-forever"></i></button>
                          <?php
                          echo '<input type="hidden" id="sched_value'.$row["sched_id"].'" name="sched_value">';
                          echo '<input type="hidden" id="user_id" name="user_id" value="'.$row["user_id"].'">';
                          echo '<input type="hidden" name="sched_id" value="'.$row["sched_id"].'"></form></td></tr>';

                    }else {
                      echo '<td><form action="../RHU/?p=updaterx" method="post">';
                      echo '<input type="hidden" name="sched_id" value="'.$row["sched_id"].'">';
                      echo '<button type="submit" class="btn btn-inverse-primary btn-rounded btn-icon"><i class="mdi mdi-pencil"></i></button></form></td></tr>';
                    }
                  }
                }

                ?>

            </tbody>
          </table>
        </div></div></div></div>
        <br><br>
             <div class="table-responsive">
        <?php


            $default_time = array("08:00 AM", "09:00 AM", "10:00 AM", "11:00 AM", "01:00 PM", "02:00 PM", "03:00 PM", "04:00 PM", "05:00 PM");
            include 'pages/view/config/dbconfig.php';
            $sql = "SELECT * FROM schedule WHERE user_id = '$user_id'  AND input_date >= ADDDATE(CURDATE(),1) ORDER BY input_date";
            $result_dates = mysqli_query($conn, $sql);
            $result_8am = mysqli_query($conn, $sql);
            $result_9am = mysqli_query($conn, $sql);
            $result_10am = mysqli_query($conn, $sql);
            $result_11am = mysqli_query($conn, $sql);
            $result_1pm = mysqli_query($conn, $sql);
            $result_2pm = mysqli_query($conn, $sql);
            $result_3pm = mysqli_query($conn, $sql);
            $result_4pm = mysqli_query($conn, $sql);
            $result_5pm = mysqli_query($conn, $sql);
            if ($result_dates->num_rows == 0) {
                echo "No Available Schedule";
            }else{
              echo '<h4 class="card-title">Calendar Schedule Summary</h4>';
              echo '<p class="card-description"></p>';
              echo '<div id="modal_display"></div>';
              echo '<table class="table table-bordered table-info">';
              echo '<thead><tr>';
              echo '<th class="bg-primary text-white"> TIME </th>';
              while($row = mysqli_fetch_assoc($result_dates)) {
                $dates = $row["input_date"];
                $day = date('D', strtotime($dates));
                $dates = date('Md', strtotime($dates));
                echo '<th class="bg-primary text-white">'.$day.'<br>'.$dates.'</th>';
              }
              echo '</tr></thead>';
              echo '<tbody>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">08:00 AM</td>';
              while($row = mysqli_fetch_assoc($result_8am)) {
              ?>
                <td><label class="time" id="<?php echo $row["sched_id"].$row["time8am"];?>" onclick="apptDateTime('<?php $time8am=$row["time8am"];($time8am=="Open") ? $time8am=$row["sched_id"].$row["time8am"]:$time8am=""; echo $time8am;?>','<?php echo $row["input_date"];?>','08:00 AM','<?php echo $row["time8am"];?>','<?php echo $row["time8am"].$row["sched_id"];?>')"><?php echo $row["time8am"]; ?></label></td>
              <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">09:00 AM</td>';
              while($row = mysqli_fetch_assoc($result_9am)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time9am"];?>" onclick="apptDateTime('<?php $time9am=$row["time9am"];($time9am=="Open") ? $time9am=$row["sched_id"].$row["time9am"]:$time9am=""; echo $time9am;?>','<?php echo $row["input_date"];?>','09:00 AM','<?php echo $row["time9am"];?>','<?php echo $row["time9am"].$row["sched_id"];?>')"><?php echo $row["time9am"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">10:00 AM</td>';
              while($row = mysqli_fetch_assoc($result_10am)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time10am"];?>" onclick="apptDateTime('<?php $time10am=$row["time10am"];($time10am=="Open") ? $time10am=$row["sched_id"].$row["time10am"]:$time10am=""; echo $time10am;?>','<?php echo $row["input_date"];?>','10:00 AM','<?php echo $row["time10am"];?>','<?php echo $row["time10am"].$row["sched_id"];?>')"><?php echo $row["time10am"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">11:00 AM</td>';
              while($row = mysqli_fetch_assoc($result_11am)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time11am"];?>" onclick="apptDateTime('<?php $time11am=$row["time11am"];($time11am=="Open") ? $time11am=$row["sched_id"].$row["time11am"]:$time11am=""; echo $time11am;?>','<?php echo $row["input_date"];?>','11:00 AM','<?php echo $row["time11am"];?>','<?php echo $row["time11am"].$row["sched_id"];?>')"><?php echo $row["time11am"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">01:00 PM</td>';
              while($row = mysqli_fetch_assoc($result_1pm)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time1pm"];?>" onclick="apptDateTime('<?php $time1pm=$row["time1pm"];($time1pm=="Open") ? $time1pm=$row["sched_id"].$row["time1pm"]:$time1pm=""; echo $time1pm;?>','<?php echo $row["input_date"];?>','01:00 PM','<?php echo $row["time1pm"];?>','<?php echo $row["time1pm"].$row["sched_id"];?>')"><?php echo $row["time1pm"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">02:00 PM</td>';
              while($row = mysqli_fetch_assoc($result_2pm)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time2pm"];?>" onclick="apptDateTime('<?php $time2pm=$row["time2pm"];($time2pm=="Open") ? $time2pm=$row["sched_id"].$row["time2pm"]:$time2pm=""; echo $time2pm;?>','<?php echo $row["input_date"];?>','02:00 PM','<?php echo $row["time2pm"];?>','<?php echo $row["time2pm"].$row["sched_id"];?>')"><?php echo $row["time2pm"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">03:00 PM</td>';
              while($row = mysqli_fetch_assoc($result_3pm)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time3pm"];?>" onclick="apptDateTime('<?php $time3pm=$row["time3pm"];($time3pm=="Open") ? $time3pm=$row["sched_id"].$row["time3pm"]:$time3pm=""; echo $time3pm;?>','<?php echo $row["input_date"];?>','03:00 PM','<?php echo $row["time3pm"];?>','<?php echo $row["time3pm"].$row["sched_id"];?>')"><?php echo $row["time3pm"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">04:00 PM</td>';
              while($row = mysqli_fetch_assoc($result_4pm)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time4pm"];?>" onclick="apptDateTime('<?php $time4pm=$row["time4pm"];($time4pm=="Open") ? $time4pm=$row["sched_id"].$row["time4pm"]:$time4pm=""; echo $time4pm;?>','<?php echo $row["input_date"];?>','04:00 PM','<?php echo $row["time4pm"];?>','<?php echo $row["time4pm"].$row["sched_id"];?>')"><?php echo $row["time4pm"]; ?></label></td>
                <?php

              }
              echo '</tr>';
              echo '<tr>';
              echo '<td class="bg-primary text-white">05:00 PM</td>';
              while($row = mysqli_fetch_assoc($result_5pm)) {
                ?>
                  <td><label class="time" id="<?php echo $row["sched_id"].$row["time5pm"];?>" onclick="apptDateTime('<?php $time5pm=$row["time5pm"];($time5pm=="Open") ? $time5pm=$row["sched_id"].$row["time5pm"]:$time5pm=""; echo $time5pm;?>','<?php echo $row["input_date"];?>','05:00 PM','<?php echo $row["time5pm"];?>','<?php echo $row["time5pm"].$row["sched_id"];?>')"><?php echo $row["time5pm"]; ?></label></td>
                <?php
              }
              echo '</tr>';
              echo '</tbody></table>';
            }
         ?>

    </div>


      </div>
    </div>
  </div>
</div>
<script src="assets/js/script.js"></script>
